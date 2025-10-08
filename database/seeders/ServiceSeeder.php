<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {$services = [
            // Preventive
            ['Consultation', 'Preventive', 500, 500],
            ['Dental Certificate', 'Preventive', 500, 500],
            ['Oral Prophylaxis (Child)', 'Preventive', 800, 800],
            ['Oral Prophylaxis (Moderate)', 'Preventive', 1000, 1200],
            ['Oral Prophylaxis (Severe)', 'Preventive', 1500, 2000],
            ['Topical Fluoride (Per Quadrant)', 'Preventive', 300, 500],
            ['Fluoride Gel', 'Preventive', 1000, 1500],
            ['Fluoride Varnish', 'Preventive', 1500, 2000],
            ['Sealants', 'Preventive', 500, 500],

            // Diagnostic
            ['Periapical X-ray', 'Diagnostic', 300, 300],

            // Add-ons
            ['Extra Anesthesia', 'Add-ons', 500, 500],

            // Restorative
            ['Temporary Filling', 'Restorative', 500, 500],
            ['Temporary Dressing', 'Restorative', 500, 500],
            ['Composite Filling (Per Surface)', 'Restorative', 1000, 1500],
            ['Amalgam Filling (Posterior)', 'Restorative', 1000, 1200],
            ['Indirect Composite', 'Restorative', 2500, 3000],
            ['Indirect Porcelain', 'Restorative', 5000, 6000],

            // Prosthodontics
            ['Jacket Crown', 'Prosthodontics', 5000, 7000],
            ['PFM Crown (Twist)', 'Prosthodontics', 8000, 9500],
            ['All Ceramic Crown', 'Prosthodontics', 20000, 25000],
            ['Crown and Bridge', 'Prosthodontics', 8000, 9500],
            ['Partial Denture', 'Prosthodontics', 4000, 99999], // example, adjust
            ['Assembled Casted Clasp', 'Prosthodontics', 2500, 4000],
            ['Staiplate (2 Pontics + 500)', 'Prosthodontics', 4000, 6000],
            ['Rebase (Laboratory)', 'Prosthodontics', 50, 99999], // percentage or lab fee
            ['Reline (Laboratory)', 'Prosthodontics', 50, 99999],

            // Pediatric Dentistry
            ['Extraction (Child)', 'Pediatric Dentistry', 1000, 1000],
            ['SSC Crown', 'Pediatric Dentistry', 2500, 3000],
            ['Space Maintainer (Uni)', 'Pediatric Dentistry', 2500, 3000],
            ['Space Maintainer (Bilateral)', 'Pediatric Dentistry', 8000, 10000],

            // Orthodontics
            ['Orthodontics (General)', 'Orthodontics', 25000, 25000],
            ['Metal Brackets', 'Orthodontics', 50000, 50000],
            ['Ceramic Brackets', 'Orthodontics', 70000, 70000],
            ['Self-Ligating Metal Brackets', 'Orthodontics', 80000, 80000],
            ['Self-Ligating Ceramic Brackets', 'Orthodontics', 90000, 90000],
            ['Clear Aligners', 'Orthodontics', 120000, 150000],
            ['Hawley’s Retainer', 'Orthodontics', 5000, 6000],
            ['Essix Retainer', 'Orthodontics', 3000, 4000],
            ['Fixed Retainers', 'Orthodontics', 4000, 5000],
            ['Temporary Anchorage Device', 'Orthodontics', 8000, 10000],
            ['Bracket Recementation', 'Orthodontics', 1000, 1500],
            ['Bracket Removal', 'Orthodontics', 1500, 2000],

            // Oral Surgery
            ['Simple Extraction', 'Oral Surgery', 1000, 1500],
            ['Complicated Extraction', 'Oral Surgery', 1500, 2500],
            ['Impaction (Per Tooth)', 'Oral Surgery', 6000, 10000],
            ['Odontotomy', 'Oral Surgery', 10000, 15000],
            ['Apicoectomy', 'Oral Surgery', 10000, 15000],
            ['Frenectomy', 'Oral Surgery', 10000, 15000],

            // Implantology
            ['Dental Implant Screw', 'Implantology', 25000, 25000],
            ['Dental Implant Abutment', 'Implantology', 15000, 15000],
            ['Dental Implant Crown', 'Implantology', 15000, 15000],
            ['Dental Implant Package (Screw + Abutment + Crown)', 'Implantology', 55000, 60000],

            // Endodontics
            ['Endodontics (Anterior)', 'Endodontics', 10000, 12000],
            ['Endodontics (Premolar)', 'Endodontics', 15000, 18000],
            ['Endodontics (Molar)', 'Endodontics', 18000, 20000],
            ['Post and Core (Per Canal)', 'Endodontics', 7000, 8000],
            ['Complete Core Build-up (Fiber Post)', 'Endodontics', 10000, 12000],

            // Special Prosthetics
            ['Bioform', 'Special Prosthetics', 24000, 26000],
            ['Ivocap', 'Special Prosthetics', 26000, 28000],
            ['Thermosens', 'Special Prosthetics', 24000, 26000],
            ['Biotone', 'Special Prosthetics', 24000, 26000],
            ['Lucitone Add-in', 'Special Prosthetics', 2500, 2500],
            ['One Piece Uni', 'Special Prosthetics', 12000, 12000],
            ['One Piece Bila', 'Special Prosthetics', 15000, 15000],
            ['Flexi Uni', 'Special Prosthetics', 12000, 12000],
            ['Flexi Bila', 'Special Prosthetics', 15000, 15000],
            ['Flex Combi (Bilateral)', 'Special Prosthetics', 15000, 15000],

            // Administrative
            ['Dental Certificate', 'Administrative', 500, 500],
        ];

        foreach ($services as $service) {
            [$name, $categoryName, $min, $max] = $service;
            $category = Category::where('name', $categoryName)->first();

            if ($category) {
                Service::firstOrCreate([
                    'name' => $name,
                    'category_id' => $category->id,
                ], [
                    'price_min' => $min,
                    'price_max' => $max,
                ]);
            }
        }
    }
}
