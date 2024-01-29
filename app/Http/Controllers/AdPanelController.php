<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Str;
use Kreait\Firebase\Auth\UserQuery;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdPanelController extends Controller
{
    public function adReg(){
        return view('adReg.index', [
            'title' => 'Admin Register'
        ]);
    }

    public function adPanel(Request $request){
        $video = Firebase::database()->getReference('videos')->getValue();
        if($request['jurusan']){
            return view('adPanel.index', [
                'title' => 'Admin Panel',
                'header' => "Welcome to Admin Panel",
                'videos' => $video,
                'jurusan' => $request['jurusan']
            ]);
        }
        return view('adPanel.index', [
            'title' => 'Admin Panel',
            'header' => "Welcome to Admin Panel",
            'videos' => $video,
            'jurusan' => array_keys($video)[0]
        ]);
    }

    public function adUsers(Request $request){
        $auth=Firebase::auth();
        if($request['search']){
            return view('adPanel.sidemenu.users',[
                'title' => 'Admin Panel | Users',
                'header' => "Users",
                'users' => $auth->listUsers(),
                'search' => true,
                'query' => $request['search']
            ]);
        } else{
            return view('adPanel.sidemenu.users',[
                'title' => 'Admin Panel | Users',
                'header' => "Users",
                'users' => $auth->listUsers(),
                'search' => false
            ]);
        }
    }

    public function delUser(Request $request){
        $auth = Firebase::auth();
        $db = Firebase::database();
        $email = Str::replace('.', '', $request['email']);
        try{
            $auth->deleteUser($request['uid']);
            $db->getReference('users/' . $email)->remove();
    
            return redirect('/adPanel/users')->with('success', 'User Berhasil Dihapus!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'User Gagal Dihapus. Silakan Coba Lagi.');
        }
    }

    public function laporan(Request $request){
        $db = Firebase::database();
        if($request['tahun']){
            return view('adPanel.sidemenu.laporan.index', [
                'title' => 'Admin Panel | Laporan',
                'header' => "Laporan",
                'snapshots' => $db->getReference('transaksi/validated')->getValue(),
                'tahun' => $request['tahun']
            ]);
        } else{
            return view('adPanel.sidemenu.laporan.index', [
                'title' => 'Admin Panel | Laporan',
                'header' => "Laporan Pendapatan Bruto EdukaS1",
                'snapshots' => $db->getReference('transaksi/validated')->getValue(),
                'tahun' => date('Y', strtotime(Carbon::now()))
            ]);
        }
    }

    public function dataTest(){
        $data=[
            'Akuntansi' => [
                'Deskripsi' => 'Akuntansi biaya adalah proses pengumpulan, pengukuran, analisis, dan pelaporan informasi terkait biaya produksi barang atau jasa dalam suatu perusahaan. Ini membantu manajer dan pemilik perusahaan dalam pengambilan keputusan terkait harga jual, strategi produksi, dan evaluasi kinerja perusahaan secara keseluruhan.',
                'Judul_Video' => 'Mata Kuliah Akuntansi Biaya Jurusan Akuntansi'
            ],
            'Manajemen' => [
                'Deskripsi' => 'Merupakan mata kuliah yang mengajarkan tentang kegiatan yang mencakup perencanaan, penganggaran, pemeriksaan, pengelolaan, pengendalian, pencarian, dan penyimpanan dana. Demi kelancaran dan keberlangsungan bisnis dalam jangka waktu lama, diperlukan manajemen keuangan yang dilakukan secara matang.',
                'Judul_Video' => 'Mata Kuliah Manajemen Keuangan Jurusan Manajemen'
            ],
            'Bisnis_Digital' => [
                'Deskripsi' => 'Mata kuliah yang mengajarkan sebuah strategi marketing untuk meningkatkan visibilitas sebuah situs web di halaman mesin pencarian seperti Google.',
                'Judul_Video' => 'Mata Kuliah Search Engine Marketing Jurusan Bisnis Digital'
            ],
            'Ilmu_Ekonomi' => [
                'Deskripsi' => 'Mata kuliah ini mengajarkan penerapan metode matematika untuk mewakili teori dan menganalisis masalah-masalah di bidang ekonomi. Dengan konvensi, metode yang diterapkan mengacu pada orang-orang di luar geometri sederhana, seperti diferensial dan integral kalkulus, perbedaan dan persamaan diferensial, matriks aljabar, matematika, pemrograman, dan metode komputasi lainnya.',
                'Judul_Video' => 'Mata Kuliah Matematika Ekonomi Jurusan Ilmu Ekonomi'
            ],
            'Ekonomi_Islam' => [
                'Deskripsi' => 'Fiqih Muamalah adalah pengetahuan tentang kegiatan atau transaksi yang berdasarkan hukum-hukum syariat ( yang bersumber dari al-qur’an dan hadis), mengenai perilaku manusia dalam kehidupannya yang diperoleh dari dalil-dalil syari’at secara terperinci.',
                'Judul_Video' => 'Mata Kuliah Fiqh Muamalah Jurusan Ekonomi Islam'
            ],
            'Hukum' => [
                'Deskripsi' => 'ketentuan-ketentuan yang mengatur hak dan kewajiban seseorang dalam masyarakat.',
                'Judul_Video' => 'Mata Kuliah Hukum Perdata'
            ],
            'Sejarah' => [
                'Deskripsi' => 'Merupakan mata kuliah yang membahas mengenai sejarah negara-negara di wilayah Asia Tenggara.',
                'Judul_Video' => 'Mata Kuliah Sejarah Asia Tenggara Jurusan Sejarah'
            ],
            'Sastra_Indonesia' => [
                'Deskripsi' => 'morfologi merupakan suatu ilmu yang mempelajari mengenai seluk-beluk kata dan juga fungsi perubahan-perubahan bentuk tersebut, baik itu dalam fungsi gramatik atau arti kata berdasarkan konteks penggunaan, maupun fungsi semantik atau arti kata berdasarkan makna kamus/leksikal.',
                'Judul_Video' => 'Mata Kuliah Morfologi Indonesia Jurusan Sastra Indonesia'
            ],
            'Bahasa_Dan_Kebudayaan_Jepang' => [
                'Deskripsi' => 'Merupakan Mata Kuliah yang mengajarkan mengenai jenis kaidah bahasa yang mengatur kriteria penggunaan kata dan kalimat dari bahasa Jepang.',
                'Judul_Video' => 'Mata Kuliah Tata Bahasa Jepang Dasar Jurusan Bahasa dan Kebudayaan Jepang'
            ],
            'Sastra_Inggris' => [
                'Deskripsi' => 'Mata Kuliah ini mengajarkan tentang kemampuan mendengarkan dan memahami dalam bahasa inggris.',
                'Judul_Video' => 'Mata Kuliah Basic Listening Jurusan Sastra Inggris'
            ],
            'Antropologi_Sosial' => [
                'Deskripsi' => 'interdisiplin dari cabang ilmu antropologi yang membahas kaitan antara sejarah, nilai sosial-budaya, dan geografi dari suatu masyarakat terhadap aktivitas atau fenomena ekonomi yang terjadi di dalam masyarakat tersebut.',
                'Judul_Video' => 'Mata Kuliah Antropologi Ekonomi Jurusan Antropologi Sosial'
            ],
            'Ilmu_Perpustakaan' => [
                'Deskripsi' => 'Merupakan Mata Kuliah yang mengajarkan mengenai sistem yang dikembangkan untuk mengatasi permasalahan dokumentasi informasi.',
                'Judul_Video' => 'Mata Kuliah Pengantar Kearsipan Jurusan Ilmu Perpustakaan'
            ],
            'Administrasi_Bisnis' => [
                'Deskripsi' => 'Mata kuliah Pengantar Ilmu Administrasi Bisnis pada dasarnya berisi pembahasan konsep dasar administrasi, konsep dasar bisnis, konsep dasar keputusan (berpikir) bisnis, terstruktur lingkungan bisnis, konsep dasar organisasi bisnis, dan konsep dasar operasi bisnis.',
                'Judul_Video' => 'Mata Kuliah Pengantar Ilmu Administrasi Bisnis Jurusan Administrasi Bisnis'
            ],
            'Administrasi_Publik' => [
                'Deskripsi' => 'Manajemen Publik merupakan cabang keilmuan dari administrasi publik yang membahas mengenai restrukturisasi organisasi, sistem penganggaran, manajemen sumberdaya dan evaluasi program.',
                'Judul_Video' => 'Mata Kuliah Manajemen Publik Jurusan Administrasi Publik'
            ],
            'Hubungan_Internasional' => [
                'Deskripsi' => 'Hubungan Internasional secara umum adalah kerjasama antarnegara, yaitu unit politik yang didefinisikan secara global untuk menyelesaikan berbagai masalah.',
                'Judul_Video' => 'Mata Kuliah Pengantar Ilmu Hubungan Internasional Jurusan Hubungan Internasional'
            ],
            'Ilmu_Komunikasi' => [
                'Deskripsi' => 'Psikologi Komunikasi membahas tentang perkembangan, pandangan, definisi, konsep, dan teori dalam komunikasi melalui sudut pandang psikologi.',
                'Judul_Video' => 'Mata Kuliah Psikologi Komunikasi Jurusan Ilmu Komunikasi'
            ],
            'Ilmu_Pemerintahan' => [
                'Deskripsi' => 'Komunikasi Pemerintahan bisa diartikan sebagai penyampaian ide, program, dan gagasan pemerintah kepada masyarakat dalam rangka mencapai tujuan negara.',
                'Judul_Video' => 'Mata Kuliah Komunikasi Pemertinahan Jurusan Ilmu Pemerintahan'
            ],
            'Kedokteran' => [
                'Deskripsi' => 'Materi tentang sistem kardiovaskuler dan sistem pernapasan manusia.',
                'Judul_Video' => 'Cardiorespiratory System'
            ],
            'Kedokteran_Gigi' => [
                'Deskripsi' => 'Materi tentang mengembalikan fungsi normal gigi dengan usaha pembuatan mahkota gigi, pembuatan gigi tiruan, terapi fungsi otot pengunyahan, atau dengan perawatan ortopedi dan ortodonti.',
                'Judul_Video' => 'Modul Kedokteran Gig Rehabilitatif'
            ],
            'Farmasi' => [
                'Deskripsi' => 'Ilmu yang mempelajari tentang bagian-bagian tanaman atau hewan yang dapat digunakan sebagai obat alami yang telah melewati berbagai macam uji seperti uji farmakodinamik, uji toksikologi dan uji biofarmasetika.',
                'Judul_Video' => 'Farmakognosi'
            ],
            'Kesehatan_Masyarakat' => [
                'Deskripsi' => 'Merupakan alat untuk mengatur tertibnya hidup bermasyarakat dalam bidang kesehatan.',
                'Judul_Video' => 'Mata Kuliah Etika dan Hukum Kesehatan'
            ],
            'Manajemen_Sumber_Daya_Perairan' => [
                'Deskripsi' => 'Ekologi perairan adalah cabang keilmuan ekologi yang membahas mengenai makhluk hidup di perairan dan faktor lingkungannya.',
                'Judul_Video' => 'Mata Kuliah Ekologi Perairan Jurusan Manajemen Sumber Daya Perairan'
            ],
            'Akuakultur' => [
                'Deskripsi' => 'Manajemen Kualitas Air mempelajari cara yang dilakukan agar kualitas air optimal untuk pertumbuhan ikan.',
                'Judul_Video' => 'Mata Kuliah Manajemen Kualitas Air Jurusan Akuakultur'
            ],
            'Perikanan_Tangkap' => [
                'Deskripsi' => 'Mata kuliah yang mempelajari peralatan yang digunakan untuk penangkapan ikan baik di perairan darat maupun perairan laut.',
                'Judul_Video' => 'Mata Kuliah Alat Penangkapan Ikan Jurusan Perikanan Tangkap'
            ],
            'Teknologi_Hasil_Perikanan' => [
                'Deskripsi' => 'Biokimia hasil perikanan mempelajari kimia dari bahan-bahan dan proses-proses yang terjadi dalam tubuh mahluk hidup, khusunya hasil perikanan sebagai upaya untuk memahami proses kehidupan dari sisi kimia perikanan.',
                'Judul_Video' => 'Mata Kuliah Biokimia Hasil Perikanan Jurusan Teknologi Hasil Perikanan'
            ],
            'Ilmu_Kelautan' => [
                'Deskripsi' => 'Ilmu yang mempelajari sejarah dan struktur dasar laut.',
                'Judul_Video' => 'Mata Kuliah Geologi Kelautan Jurusan Ilmu Kelautan'
            ],
            'Oseanografi' => [
                'Deskripsi' => 'Ilmu yang mempelajari hubungan antara sifat-sifat fisika yang terjadi dalam lautan sendiri dan yang terjadi antara lautan dengan atmosfer dan daratan termasuk kejadian-kejadian seperti terjadinya tenaga pembangkit pasang dan gelombang, iklim, dan sistem arus yang terdapat di lautan.',
                'Judul_Video' => 'Mata Kuliah Oseanografi Fisika Jurusan Oseanografi'
            ],
            'Peternakan' => [
                'Deskripsi' => 'Ilmu peternakan adalah ilmu yang mempelajari segala sesuatu yang bersangkutan dengan usaha manusia untuk beternak atau mengusahakan peternakan dari berbagai jenis hewan untuk memperoleh manfaat dari padanya.',
                'Judul_Video' => 'Mata Kuliah Pengantar Ilmu Peternakan Jurusan Peternakan'
            ],
            'Teknologi_Pangan' => [
                'Deskripsi' => 'Mikrobiologi pangan adalah studi terhadap mikroorganisme yang mendiami, membuat, hingga yang merusak makanan.',
                'Judul_Video' => 'Mata Kuliah Mikrobiologi Pangan Jurusan Teknologi Pangan'
            ],
            'Agroekoteknologi' => [
                'Deskripsi' => 'ekologi tumbuhan diartikan sebagai ilmu pengetahuan yang mempelajari secara spesifik interaksi tumbuhan dengan lingkungan hidupnya, yang berhubungan dengan proses dan fenomena alam.',
                'Judul_Video' => 'Mata Kuliah Ekologi Tumbuhan Jurusan Agroekoteknologi'
            ],
            'Agribisnis' => [
                'Deskripsi' => 'Agribisnis adalah usaha yang bergerak di bidang pertanian, terutama dalam hal penyediaan pangan.',
                'Judul_Video' => 'Mata Kuliah Pengantar Agribisnis Jurusan Agribisnis'
            ],
            'Psikologi' => [
                'Deskripsi' => 'Psikologi kognitif merupakan ilmu yang mempelajari proses mental seperti perhatian, penggunaan bahasa, persepsi, pemecahan masalah, kreatifitas, dan penalaran.',
                'Judul_Video' => 'Mata Kuliah Psikologi Kognitif'
            ],
            'Matematika' => [
                'Deskripsi' => 'Trigonometri adalah sebuah cabang matematika yang mempelajari hubungan yang meliputi panjang dan sudut segitiga.',
                'Judul_Video' => 'Mata Kuliah Trigonometri Jurusan Matematika'
            ],
            'Fisika' => [
                'Deskripsi' => 'Dalam ilmu fisika, elektromagnetisme merupakan interaksi yang terjadi antar partikel bermuatan listrik melalui medan elektromagnetik.',
                'Judul_Video' => 'Mata Kuliah Elektromagnetik Jurusan Fisika'
            ],
            'Biologi' => [
                'Deskripsi' => 'Taksonomi adalah cabang ilmu biologi yang menelaah penamaan, perincian, serta juga pengelompokan makhluk hidup dengan berdasarkan persamaan.',
                'Judul_Video' => 'Mata Kuliah Taksonomi Jurusan Biologi'
            ],
            'Kimia' => [
                'Deskripsi' => 'Kimia Organik adalah bidang ilmu yang mempelajari tentang struktur, sifat-sifat, perubahan, komposisi, reaksi dan sintesis senyawa yang mengandung atom karbon tidak hanya senyawa hidrokarbon, tetapi juga senyawa yang mengandung unsur lain, seperti hidrogen, nitrogen, oksigen, halogen fosfor, silikon dan sulfur.',
                'Judul_Video' => 'Mata Kuliah Kimia Organik Jurusan Kimia'
            ],
            'Statistika' => [
                'Deskripsi' => 'Riset Operasi merupakan sebuah keilmuan yang mempelajari pengembangan dan penerapan metode analitik untuk meningkatkan hasil pengambilan keputusan.',
                'Judul_Video' => 'Mata Kuliah Riset Operasi Jurusan Statistika'
            ],
            'Informatika' => [
                'Deskripsi' => 'Mata kuliah ini menjelaskan konsep dasar matematika kepada mahasiswa meliputi tentang himpunan, fungsi, relasi dan graph selain itu juga mengenai kombinatorik, system formal, tree dan aplikasi pemrograman agar memberikan dasar matematis untuk kuliah - kuliah di ilmu komputer.',
                'Judul_Video' => 'Mata Kuliah Struktur Diskrit Jurusan Informatika'
            ],
            'Bioteknologi' => [
                'Deskripsi' => 'Bioteknologi industri adalah aplikasi bioteknologi untuk memenuhi tujuan aktivitas industri, termasuk manufaktur, bioenergi, dan biomaterial.',
                'Judul_Video' => 'Mata Kuliah Bioteknologi Industri Jurusan Bioteknologi'
            ],
            'Teknik_Sipil' => [
                'Deskripsi' => 'Rekayasa lalu lintas merupakan serangkaian usaha dan kegiatan yang meliputi perencanaan, pengadaan, pemasangan, pengaturan, dan pemeliharaan fasilitas perlengkapan jalan dalam rangka mewujudkan dan memelihara keamanan, keselamatan, ketertiban, dan kelancaran lalu lintas.',
                'Judul_Video' => 'Mata Kuliah Rekayasa Lalu Lintas Jurusan Teknik Sipil'
            ],
            'Arsitektur' => [
                'Deskripsi' => 'Perancangan Arsitektur adalah penggabungan berbagai unsur ruang untuk menampung suatu proses kegiatan sehingga menghasilkan suatu keseluruhan yang lebih kaya dan bermakna.',
                'Judul_Video' => 'Mata Kuliah Perancangan Arsitektur Jurusan Arsitektur'
            ],
            'Teknik_Kimia' => [
                'Deskripsi' => 'Teknik Kimia merupakan sebuah bidang keteknikan yang mempelajari operasi, bentuk, serta metode meningkatkan hasil produksi tumbuhan kimia.',
                'Judul_Video' => 'Mata Kuliah Pengantar Teknik Kimia Jurusan Teknik Kimia'
            ],
            'Teknik_Perencanaan_Wilayah_Dan_Kota' => [
                'Deskripsi' => 'Perencanaan wilayah adalah penetapan langkah-langkah yang digunakan untuk wilayah tertentu sesuai dengan tujuan yang telah ditetapkan.',
                'Judul_Video' => 'Mata Kuliah Perencanaan Wilayah Jurusan Teknik Perencanaan Wilayah dan Kota'
            ],
            'Teknik_Mesin' => [
                'Deskripsi' => 'Mekanika bahan adalah cabang dari mekanika terapan yang membahas perilaku benda padat yang mengalami berbagai pembebanan.',
                'Judul_Video' => 'Mata Kuliah Mekanika Kekuatan Bahan Jurusan Teknik Mesin'
            ],
            'Teknik_Elektro' => [
                'Deskripsi' => 'Rangkaian listrik adalah sumber listrik dengan alat-alat listrik lainnya yang mempunyai berbagai fungsi-fungsi tertentu.',
                'Judul_Video' => 'Mata Kuliah Rangkaian Listrik Jurusan Teknik Elektro'
            ],
            'Teknik_Perkapalan' => [
                'Deskripsi' => 'Materi dari mata kuliah ini menjelaskan bagaimana membuat desain kapal yang dapat bekerja dengan baik dan maksimal.',
                'Judul_Video' => 'Mata Kuliah Desain Kapal Jurusan Teknik Perkapalan'
            ],
            'Teknik_Industri' => [
                'Deskripsi' => 'metode produksi di mana komponen atau bahan baku dicampurkan dengan mengikut formula atau resep—sering kali memerlukan panas, waktu, dan/atau tekanan—untuk menghasilkan barang.',
                'Judul_Video' => 'Mata Kuliah Proses Manufaktur Jurusan Teknik Industri'
            ],
            'Teknik_Lingkungan' => [
                'Deskripsi' => 'Kimia lingkungan adalah studi ilmiah terhadap fenomena kimia dan biokimia yang terjadi di alam.',
                'Judul_Video' => 'Mata Kuliah Kimia Lingkungan Jurusan Teknik Lingkungan'
            ],
            'Teknik_Geologi' => [
                'Deskripsi' => 'Geofisika adalah bagian dari ilmu bumi yang mempelajari bumi menggunakan kaidah atau prinsip-prinsip fisika.',
                'Judul_Video' => 'Mata Kuliah Geofisika Jurusan Teknik Geologi'
            ],
            'Teknik_Geodesi' => [
                'Deskripsi' => 'Fotogrametri atau aerial surveying adalah teknik pemetaan melalui foto udara.',
                'Judul_Video' => 'Mata Kuliah Fotogrametri Jurusan Teknik Geodesi'
            ],
            'Umum' => [
                'Deskripsi' => 'pendidikan keagamaan adalah pendidikan yang mempersiapkan peserta didik untuk dapat menjalankan peranan yang menuntut penguasaan pengetahuan tentang ajaran agama dan/atau menjadi ahli ilmu agama dan mengamalkan ajaran agamanya.',
                'Judul_Video' => 'Pendidikan Agama'
            ],
        ];

        $body=[
            'Akuntansi' => 'Akuntansi merupakan pemrosesan informasi mengenai suatu satuan ekonomi seperti bisnis dan perusahaan.',
            'Manajemen' => 'Manajemen adalah proses pengorganisasian, pengaturan, pengelolaan SDM, sampai dengan pengendalian agar bisa mencapai tujuan dari suatu kegiatan.',
            'Bisnis_Digital' => 'Bisnis digital adalah pemanfaatan teknologi digital untuk menciptakan berbagai keunikan, mulai dari model bisnis hingga pengalaman pelanggan.',
            'Ilmu_Ekonomi' => 'Ekonomi adalah ilmu sosial yang mempelajari produksi, distribusi, dan konsumsi barang dan jasa.',
            'Ekonomi_Islam' => 'Ekonomi Islam merujuk pada pengetahuan ekonomi atau aktifitas dan proses ekonomi dalam prinsip dan ajaran Islam.',
            'Hukum' => 'Ilmu hukum adalah ilmu yang mandiri dan seharusnya dapat bekerja sendiri sesuai dengan konsep-konsep hukum yang murni dan menghasilkan hukum yang sesuai dengan perkembangan masyarakat yang lebih modern.
            ',
            'Sejarah' => 'Sejarah adalah penelitian dan dokumentasi yang sistematis terhadap masa lalu umat manusia.',
            'Sastra_Indonesia' => 'Sastra Indonesia merujuk hanya kepada kesusastraan dalam bahasa Indonesia yang bahasa akarnya berdasarkan bahasa Melayu (di mana bahasa Indonesia adalah satu turunannya).',
            'Bahasa_Dan_Kebudayaan_Jepang' => 'Merupakan bidang yang mempelajari seputar Bahasa dan Kebudayaan Jepang.',
            'Sastra_Inggris' => 'Sastra Inggris merujuk pada tiap bentuk kesusastraan yang ditulis dalam bahasa inggris dari belahan dunia yang menggunakan bahasa inggris.',
            'Antropologi_Sosial' => 'Antropologi Sosial merupakan studi tentang pola perilaku dalam masyarakat dan kebudayaan manusia.',
            'Ilmu_Perpustakaan' => 'Ilmu Perpustakaan adalah jurusan yang mempelajari cara mengumpulkan, menganalisis, mengolah, mengelola, dan mengomunikasikan informasi dari berbagai media, seperti dokumen, buku, ataupun digital.',
            'Administrasi_Bisnis' => 'Administrasi Bisnis merupakan bidang tata usaha dari perusahaan komersial.',
            'Administrasi_Publik' => 'Administrasi Publik merupakan cabang dari ilmu politik yang mempelajari struktur, fungsi, dan perilaku dari institusi publik.',
            'Hubungan_Internasional' => 'Hubungan Internasional dapat diartikan secara umum sebagai kerjasama antar negara, yaitu unit politik yang didefinisikan secara global untuk menyelesaikan berbagai masalah.',
            'Ilmu_Komunikasi' => 'Ilmu komunikasi merupakan disiplin ilmu yang mempelajari berbagai aspek tentang komunikasi manusia, baik secara verbal maupun nonverbal.',
            'Ilmu_Pemerintahan' => 'Ilmu Pemerintahan merupakan bidang yang mengkaji berbagai permasalahan organisasi, administrasi, manajemen, dan kepemimpinan dalam penyelenggaraan organisasi maupun badan publik yang bertugas melaksanakan kekuasaan negara sebagaimana tertuang dalam peraturan perundang-undangan.',
            'Kedokteran' => 'Ilmu atau seni yang berkecimpung dalam pemeliharaan kesehatan, serta pencegahan, pengobatan atau penatalaksanaan penyakit.',
            'Kedokteran_Gigi' => 'Kedokteran Gigi adalah program studi yang mempelajari tentang perawatan kesehatan oral manusia, mulai dari daerah gigi dan mulut, sampai cara mengobati berbagai permasalahan pada area tersebut.',
            'Farmasi' => 'Farmasi merupakan ilmu dan praktik dalam menemukan, memroduksi, menyiapkan, menyebarkan, menilai, dan mengawasi pengobatan dengan tujuan memastikan keamanan, keefektifan, serta keterjangkauan penggunaan obat-obatan.',
            'Kesehatan_Masyarakat' => 'Kesehatan Masyarakat didefinisikan sebagai ilmu dan seni mencegah penyakit, memperpanjang hidup, dan meningkatkan kualitas hidup dengan melakukan upaya-upaya terorganisasi dan memberi pilihan informasi kepada masyarakat, organisasi (publik dan swasta), komunitas, dan individu.',
            'Manajemen_Sumber_Daya_Perairan' => 'Manajemen Sumber Daya Perairan mempelajari tentang kegiatan atau proses perencanaan, pengorganisasian, pemanfaatan, dan juga pengelolaan sumber daya perairan.',
            'Akuakultur' => 'Akuakultur merupakan bentuk pemeliharaan dan penangkaran berbagai macam hewan atau tumbuhan perairan yang menggunakan air sebagai komponen pokoknya.',
            'Perikanan_Tangkap' => 'Perikanan Tangkap adalah usaha penangkapan ikan dan organisme air lainnya di alam liar (laut, sungai, danau, dan badan air lainnya).',
            'Teknologi_Hasil_Perikanan' => 'Teknologi Hasil Perikanan mempelajari bagaimana mengolah hasil perikanan dari pasca panen hingga menghasilkan produk perikanan berkualitas tinggi yang zero waste dan ramah lingkungan, juga mempelajari manajemen industri dan bisnis perikanan.',
            'Ilmu_Kelautan' => 'Ilmu Kelautan merupakan bidang studi yang mempelajari lautan, organisme laut, gelombang, samudera, dan juga geofisika. ',
            'Oseanografi' => 'Oseanografi adalah cabang ilmu bumi yang mempelajari samudra atau lautan.',
            'Peternakan' => '',
            'Teknologi_Pangan' => '',
            'Agroekoteknologi' => '',
            'Agribisnis' => '',
            'Psikologi' => '',
            'Matematika' => '',
            'Fisika' => '',
            'Biologi' => '',
            'Kimia' => '',
            'Statistika' => '',
            'Informatika' => '',
            'Bioteknologi' => '',
            'Teknik_Sipil' => '',
            'Arsitektur' => '',
            'Teknik_Kimia' => '',
            'Teknik_Perencanaan_Wilayah_Dan_Kota' => '',
            'Teknik_Mesin' => '',
            'Teknik_Elektro' => '',
            'Teknik_Perkapalan' => '',
            'Teknik_Industri' => '',
            'Teknik_Lingkungan' => '',
            'Teknik_Geologi' => '',
            'Teknik_Geodesi' => '',
            'Teknik_Komputer' => '',
            'Umum' => '',
        ];

        $db=Firebase::database();

        $auth=Firebase::Auth();

        // foreach($data as $satuan){
        //     dump(array_keys($data));
        // }
        
        foreach($db->getReference('users')->getValue() as $snapshot){
            dump($snapshot);
        }

        // dump($auth->getUser(Session::get('firebaseUserId'))->customClaims['role']);
        // dump(array_keys($db->getReference('faculties')->getValue()));
        // dump(array_keys($db->getReference('users')->getValue()));
        // dump($db->getReference('faculties/Teknik/jurusan')->getValue());
        // dump(Str::replace(' ', '_', $db->getReference('faculties/Teknik/jurusan')->getValue()));
        // dump(Str::contains('Teknik', Str::replace(' ', '_', $db->getReference('faculties/Teknik/jurusan')->getValue())));
    }
}
