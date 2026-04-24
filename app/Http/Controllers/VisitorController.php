<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Visitor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VisitorController extends Controller
{
    /**
     * Display the guestbook form.
     */
    public function index()
    {
        return view('visitor.index');
    }

    /**
     * Store a newly created visitor in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'pangkat' => 'nullable|string|max:255',
            'satuan' => 'nullable|string|max:255',
            'judul_buku' => 'nullable|string|max:255',
            'foto' => 'required|string', // Base64 image string
        ]);

        try {
            $visitor = new Visitor();
            $visitor->nama_lengkap = $request->nama_lengkap;
            $visitor->pangkat = $request->pangkat;
            $visitor->satuan = $request->satuan;
            $visitor->judul_buku = $request->judul_buku;

            if ($request->foto) {
                // More robust base64 image parsing
                $imageData = $request->foto;
                if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                    $imageData = substr($imageData, strpos($imageData, ',') + 1);
                    $type = strtolower($type[1]); // png, jpg, etc.

                    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                        throw new \Exception('Format gambar tidak didukung.');
                    }

                    $imageData = base64_decode($imageData);

                    if ($imageData === false) {
                        throw new \Exception('Dekode gambar gagal.');
                    }
                } else {
                    throw new \Exception('Data gambar tidak valid.');
                }

                $imageName = 'visitor_' . time() . '_' . Str::random(10) . '.' . $type;
                
                Storage::disk('public')->put('visitors/' . $imageName, $imageData);
                $visitor->foto_path = 'visitors/' . $imageName;
            }

            $visitor->save();

            return response()->json([
                'success' => true,
                'message' => 'Data kunjungan berhasil disimpan!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display visitors for admin.
     */
    public function adminIndex(Request $request)
    {
        $range = $request->query('range', '7'); // default 7 days
        $days = (int)$range;

        $visitors = Visitor::latest()->paginate(10);
        
        // Stats
        $stats = [
            'total' => Visitor::count(),
            'today' => Visitor::whereDate('created_at', today())->count(),
            'this_period' => Visitor::where('created_at', '>=', now()->subDays($days))->count(),
        ];

        // Data for chart
        $chartData = Visitor::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.visitors.index', compact('visitors', 'chartData', 'stats', 'range'));
    }
    /**
     * Remove the specified visitor from storage.
     */
    public function destroy(Visitor $visitor)
    {
        // Delete image file if exists
        if ($visitor->foto_path) {
            Storage::disk('public')->delete($visitor->foto_path);
        }
        
        $visitor->delete();
        return back()->with('success', 'Data kunjungan berhasil dihapus.');
    }

    /**
     * Remove all visitors from storage.
     */
    public function destroyAll()
    {
        // Delete all images first
        $visitors = Visitor::all();
        foreach ($visitors as $visitor) {
            if ($visitor->foto_path) {
                Storage::disk('public')->delete($visitor->foto_path);
            }
        }
        
        // Clear table
        Visitor::query()->delete();
        
        return back()->with('success', 'Semua data kunjungan telah dibersihkan.');
    }
}
