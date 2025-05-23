<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DatasetController extends Controller
{
    public function index()
    {
        $metrics = DB::table('dataset_metrics')->get();
        
        $datasets = [
            'training' => $this->getDatasetInfo('training'),
            'testing' => $this->getDatasetInfo('testing')
        ];
        
        return view('datasets.index', compact('datasets', 'metrics'));
    }
    
    private function getDatasetInfo($type)
    {
        $path = "datasets/{$type}";
        $files = Storage::disk('public')->files($path);
        
        return [
            'count' => count($files),
            'size' => $this->getDirectorySize($path),
            'types' => $this->getImageTypes($files)
        ];
    }
    
    private function getDirectorySize($path)
    {
        $totalSize = 0;
        $files = Storage::disk('public')->files($path);
        
        foreach ($files as $file) {
            $totalSize += Storage::disk('public')->size($file);
        }
        
        return round($totalSize / (1024 * 1024), 2); // Convert to MB
    }
    
    private function getImageTypes($files)
    {
        $types = [];
        foreach ($files as $file) {
            $extension = strtoupper(pathinfo($file, PATHINFO_EXTENSION));
            $types[$extension] = ($types[$extension] ?? 0) + 1;
        }
        return $types;
    }
}