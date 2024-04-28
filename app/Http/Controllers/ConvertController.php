<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConvertController extends Controller
{
    public function convertFile(Request $request)
    {
        try {
            $request->validate([
                'xmlFile' => 'required|file|mimes:xml',
            ]);

            $xmlData = file_get_contents($request->file('xmlFile')->getRealPath());

            if ($xmlData === false) {
                throw new \Exception('Failed to read XML file.');
            }

            $csvContent = $this->xmlToCsv($xmlData);

            if ($csvContent === false) {
                throw new \Exception('Failed to convert XML to CSV.');
            }

            return response()->streamDownload(function () use ($csvContent) {
                echo $csvContent;
            }, 'converted_data.csv');
        } catch (\Exception $e) {
            // Handle any exceptions
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function convertText(Request $request)
    {
        try {
            $request->validate([
                'xmlData' => 'required|string',
            ]);

            $xmlData = $request->input('xmlData');

            $csvContent = $this->xmlToCsv($xmlData);

            if ($csvContent === false) {
                throw new \Exception('Failed to convert XML to CSV.');
            }

            return response()->streamDownload(function () use ($csvContent) {
                echo $csvContent;
            }, 'converted_data.csv');
        } catch (\Exception $e) {
            // Handle any exceptions
            return back()->withErrors([$e->getMessage()]);
        }
    }

    private function xmlToCsv($xmlString)
    {
        try {
            $csvContent = '';
            $xml = simplexml_load_string($xmlString);

            if ($xml === false) {
                throw new \Exception('Failed to load XML data.');
            }

            $headers = array();
            foreach ($xml->children()[0]->children() as $child) {
                $headers[] = $child->getName();
            }
            $csvContent .= implode(',', $headers) . "\n";
            foreach ($xml->children() as $row) {
                $rowData = array();
                foreach ($row->children() as $child) {
                    $rowData[] = (string) $child;
                }
                $csvContent .= implode(',', $rowData) . "\n";
            }
            return $csvContent;
        } catch (\Exception $e) {
            // Handle any exceptions
            return false;
        }
    }
}
