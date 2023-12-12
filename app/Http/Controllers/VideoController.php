<?php

namespace App\Http\Controllers;

use FFMpeg;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'input' => 'required|string',
            'output' => 'required|string',
        ]);

        $inputPath = $request->input('input');
        $outputPath = $request->input('output');

        $ffmpeg = FFMpeg\FFMpeg::create();

        $video = $ffmpeg->open($inputPath);

        // For example, resize the video
        $video->filters()->resize(new FFMpeg\Coordinate\Dimension(640, 480))->synchronize();

        // Save the processed video to the output path
        $video->save($outputPath);

        return response()->json(['message' => 'Video processed successfully']);
    }
}
