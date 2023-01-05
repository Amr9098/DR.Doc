<?php

namespace Modules\Specialization\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SeedSpecializationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('specializations')->insert([
            'name' => 'Nutrition and Health Care Management',
            'description' => 'Health care management encompasses the efforts
             involved in planning, directing, and coordinating nonclinical
              activities within health care systems, organizations, and networks.
            ',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Dermatology',
            'description' => 'Dermatology or skin science and its 
            diseases is a medical specialty that deals with diseases that 
            affect the skin and mucous membranes, as well as nail
             and hair diseases.
            ',
        ]);


        DB::table('specializations')->insert([
            'name' => 'Ear, nose and throat surgery',
            'description' => 'Otolaryngologists are doctors trained 
            to treat patients with disorders
             or diseases of the ear, nose, or throat. In some cases,
              these disorders may require surgery. 
            ',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Obstetrics and gynecology',
            'description' => ' Physicians specializing in ophthalmology develop comprehensive 
            medical and surgical care of the eyes. Ophthalmologists diagnose and treat vision problems. ',
        ]);

        DB::table('specializations')->insert([
            'name' => 'Dentistry',
            'description' => '',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Gastroenterology and Hepatology',
            'description' => '',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Orthopaedic surgery',
            'description' => '',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Pediatrics',
            'description' => '',
        ]);
        DB::table('specializations')->insert([
            'name' => 'General surgery',
            'description' => '',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Internal Medicine',
            'description' => '',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Neuro surgery',
            'description' => '',
        ]);
        DB::table('specializations')->insert([
            'name' => 'thoracic surgery',
            'description' => '',
        ]);

        DB::table('specializations')->insert([
            'name' => 'Plastic and reconstructive surgery',
            'description' => '',
        ]);





        DB::table('specializations')->insert([
            'name' => 'Cardiac surgery',
            'description' => 'Cardiothoracic surgeons specialise in operating on the heart, 
            lungs and other thoracic (chest) organs.',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Allergy and Immunology',
            'description' => 'Specialists in allergy and immunology
             work with both adult and pediatric patients suffering from allergies and 
             diseases of the respiratory tract or immune system',
        ]);

        DB::table('specializations')->insert([
            'name' => 'Anesthesiology',
            'description' => 'Anesthesiology is the branch of medicine dedicated 
            to pain relief for patients before, during, and after surgery',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Dermatology',
            'description' => 'Dermatologists are physicians who treat adult and pediatric
             patients with disorders of the skin, hair, nails, and adjacent mucous membranes',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Emergency medicine',
            'description' => 'Physicians specializing in emergency medicine provide care for 
            adult and pediatric patients in emergency situations.',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Internal medicine',
            'description' => 'An internist is a physician who treats diseases of the heart, blood,
             kidneys, joints, digestive, respiratory, and vascular systems of adolescent, adult, and elderly patients.',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Neurology',
            'description' => 'Neurology is the specialty within the medical field pertaining 
            to nerves and the nervous system.',
        ]);
     
        DB::table('specializations')->insert([
            'name' => 'Pediatrics',
            'description' => 'Physicians specializing in pediatrics work to diagnose and treat patients 
            from infancy through adolescence. Pediatricians practice 
            preventative medicine and also diagnose common childhood
             diseases, such as asthma, allergies, and croup. ',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Psychiatry',
            'description' => 'Physicians specializing in psychiatry devote their 
            careers to mental health and its associated mental and physical ramifications.',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Radiation oncology',
            'description' => 'Physicians specializing in radiation oncology treat 
            cancer with the use of high-energy radiation therapy. ',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Surgery',
            'description' => ' General surgeons provide a wide variety of life-saving surgeries, 
            such as appendectomies and splenectomies.
             They receive broad training on human anatomy, 
             physiology, intensive care, and wound healing.',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Urology',
            'description' => ' Urology is the health care segment that cares for the male and female
             urinary tract, including kidneys, ureters, bladder, and urethra. It also deals with the male sex organs.
             Urologists have knowledge of surgery, internal medicine, pediatrics, gynecology, and more.',
        ]);
    }
}
