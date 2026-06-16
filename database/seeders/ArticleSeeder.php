<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::create([
            'title' => '2026 Hospital Solarisation Initiative. Applications Now Open for Hospitals',
            'slug' => '2026-hospital-solarisation-initiative-applications-now-open',
            'category' => 'Announcement',
            'image' => 'hospital-icu-beds.jpg',
            'excerpt' => 'The 2026 Hospital Solarisation Initiative is now open for applications. Public hospitals across Nigeria can now apply for solarisation funding to upgrade their energy infrastructure.',
            'content' => <<<'CONTENT'
<p>The National Committee on Energy Efficiency, Innovation, and Certification (NCEEIC) is pleased to announce the opening of applications for the 2026 Hospital Solarisation Initiative.</p>

<h3>About the Initiative</h3>
<p>This groundbreaking programme aims to provide reliable, clean energy to public hospitals across Nigeria through solar power installation. The initiative is part of NCEEIC's broader commitment to sustainable development and energy security in the healthcare sector.</p>

<h3>Eligibility</h3>
<p>Public hospitals registered with the Federal or State Ministry of Health are eligible to apply. Hospitals must demonstrate:</p>
<ul>
    <li>Current energy challenges affecting service delivery</li>
    <li>Commitment to maintenance and sustainable operations</li>
    <li>Adequate infrastructure for solar installation</li>
</ul>

<h3>How to Apply</h3>
<p>All applications must be submitted through our Hospital Initiative Portal. The process is simple and transparent:</p>
<ol>
    <li>Register your hospital on the portal</li>
    <li>Complete the application form with required documentation</li>
    <li>Submit and track your application in real-time</li>
</ol>

<h3>Key Dates</h3>
<p><strong>Application Opens:</strong> 15th June 2026<br>
<strong>Application Closes:</strong> Will be communicated.<br>
<strong>Selection Announcement:</strong> Will be communicated.</p>

<p>For more information and to apply, visit our Hospital Initiative Portal or contact the NCEEIC Secretariat.</p>
CONTENT,
            'published_at' => Carbon::createFromDate(2026, 6, 15),
            'published' => true,
        ]);

        Article::create([
            'title' => 'Nigeria Signs Renewable Energy MoU With Turkish, European Firms',
            'slug' => 'nigeria-signs-renewable-energy-mou-with-turkish-european-firms',
            'category' => 'News',
            'image' => 'renewable-energy-mou.jpeg',
            'excerpt' => 'Nigeria has recorded a major breakthrough in its renewable energy drive following the signing of a landmark Memorandum of Understanding (MoU) between the National Committee on Energy Efficiency, Innovation and Certification (NCEEIC) and leading European and Turkish energy and finance companies.',
            'content' => <<<'CONTENT'
<p>The agreement was signed during a high-level strategic visit to Turkey led by the National Coordinator of NCEEIC, Hon. Nwadavid Chijioke, who headed the Nigerian delegation for the engagement and MoU signing ceremony.</p>

<h3>News Summary</h3>
<p>The MoU was signed between NCEEIC, Altimapa Limited of the United Kingdom, Alfa Solar Energy of Turkey, and Peninsula Corporate Finance, also based in Turkey.<p/>
<p>
Stakeholders said the partnership is expected to accelerate Nigeria’s transition to sustainable energy through the implementation of several renewable energy projects across the country.<p/>
<p>
Among the proposed projects are the establishment of a Solar PV Quality Assurance Laboratory, deployment of solar energy solutions in healthcare facilities nationwide, development of utility-scale solar farms, and creation of local solar manufacturing plants.<p/>
<p>
Speaking on the development, Hon. Chijioke described the agreement as a major step toward strengthening Nigeria’s clean energy capacity and expanding international collaboration in sustainable development.<p/>
<p>
“This partnership represents a strategic milestone in Nigeria’s renewable energy journey. It reflects our commitment to driving innovation, improving energy access, and creating sustainable solutions that will positively impact millions of Nigerians,” he said.<p/>
<p>
He added that the partnership would not only improve energy security but also stimulate industrial growth and employment opportunities in the country.<p/>
<p>
“With the establishment of local manufacturing facilities and quality assurance systems, Nigeria is positioning itself as a major hub for renewable energy innovation and investment in Africa,” Chijioke stated.<p/>
<p>
According to stakeholders involved in the agreement, the planned solarization of healthcare facilities is expected to improve medical services, especially in rural and underserved communities where unstable electricity supply remains a major challenge.<p/>
<p>
They noted that uninterrupted power supply in hospitals would strengthen healthcare delivery, preserve critical medical equipment, and ultimately save lives.<p/>
<p>
Industry experts also said the collaboration would help diversify Nigeria’s energy sources, reduce dependence on fossil fuels, and support efforts aimed at addressing persistent electricity challenges.<p/>
<p>
Environmental analysts described the initiative as being in line with Nigeria’s climate commitments and global efforts to reduce carbon emissions through cleaner energy alternatives.<p/>
<p>
Another major aspect of the agreement is the proposed Solar PV Quality Assurance Laboratory, which stakeholders said would improve standards for solar products, enhance investor confidence, and promote technological advancement in the renewable energy sector.<p/>
<p>
Officials at the signing ceremony described the successful engagement in Turkey as evidence of Nigeria’s growing commitment to clean energy solutions and strategic international partnerships capable of accelerating national development.<p/>
<p>
As implementation begins, the projects are expected to boost energy access, create jobs, encourage local engineering expertise, and strengthen Nigeria’s position in Africa’s renewable energy sector.</p>

<p><strong>Source:</strong> <a href="https://dailytrust.com/nigeria-signs-renewable-energy-mou-with-turkish-european-firms/">Daily Trust</a></p>
CONTENT,
            'published_at' => Carbon::createFromDate(2026, 5, 3),
            'published' => true,
        ]);

        Article::create([
            'title' => 'NCEEIC Releases Updated Certification Framework for Solar Installers Nationwide',
            'slug' => 'nceeic-releases-updated-certification-framework-solar-installers',
            'category' => 'Policy',
            'image' => 'solar-panels.jpg',
            'excerpt' => 'NCEEIC has released an updated certification framework for solar installers across Nigeria, ensuring quality and safety standards in the renewable energy sector.',
            'content' => <<<'CONTENT'
<p>The National Committee on Energy Efficiency, Innovation, and Certification is proud to announce the release of the Updated Certification Framework for Solar Installers across Nigeria.</p>

<h3>Framework Overview</h3>
<p>This comprehensive framework establishes rigorous standards for solar installation professionals, ensuring the quality, safety, and reliability of solar energy systems deployed throughout Nigeria.</p>

<h3>Key Components</h3>
<ul>
    <li><strong>Technical Competency:</strong> Rigorous testing for solar installation and maintenance skills</li>
    <li><strong>Safety Standards:</strong> Adherence to international electrical safety protocols</li>
    <li><strong>Quality Assurance:</strong> Installation quality verification and certification</li>
    <li><strong>Professional Development:</strong> Continuing education requirements</li>
    <li><strong>Code of Ethics:</strong> Professional conduct standards</li>
</ul>

<h3>Benefits</h3>
<p>This framework protects consumers, ensures system reliability, and promotes the professional development of solar technicians across Nigeria. It positions Nigeria as a hub for quality renewable energy services in West Africa.</p>

<h3>Certification Levels</h3>
<p>The framework introduces three certification levels:</p>
<ol>
    <li><strong>Level 1:</strong> Basic solar installation and maintenance</li>
    <li><strong>Level 2:</strong> Advanced system design and grid integration</li>
    <li><strong>Level 3:</strong> Professional consultant and auditor status</li>
</ol>

<h3>Implementation</h3>
<p>The framework takes effect immediately, with a transition period for existing installers to obtain certification. Detailed guidelines and application procedures are available on our website.</p>
CONTENT,
            'published_at' => Carbon::createFromDate(2026, 4, 22),
            'published' => true,
        ]);
    }
}
