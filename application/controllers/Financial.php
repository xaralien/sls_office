<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Financial extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //$this->load->model('M_cuti');
        $this->load->model(['m_coa', 'm_invoice', 'M_Customer']);
        $this->load->library(['form_validation', 'session', 'user_agent', 'Api_Whatsapp', 'pagination', 'pdfgenerator']);
        $this->load->database();
        $this->load->helper(['url', 'form', 'download', 'date', 'number']);

        $this->cb = $this->load->database('corebank', TRUE);

        // if (!$this->session->userdata('nip')) {
        //     redirect('login');
        // }
        if ($this->session->userdata('isLogin') == FALSE) {
            redirect('login/login_form');
        }
    }

    // private function add_log($action, $record_id, $tableName)
    // {
    //     // Dapatkan user ID dari sesi atau sesuai kebutuhan aplikasi Anda
    //     $user_id = $this->session->userdata('id_user');
    //     // Tambahkan log
    //     $this->M_Logging->add_log($user_id, $action, $tableName, $record_id);
    // }

    public function index()
    {
    }

    public function financial_entry()
    {
        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $res2 = $query->result_array();
        $result = $res2[0]['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $res2 = $query2->result_array();
        $result2 = $res2[0]['COUNT(id)'];

        $data = [
            'coa' => $this->m_coa->list_coa(),
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'title' => "Financial entry",
            'pages' => "pages/financial/v_financial_entry",
        ];

        $this->load->view('index', $data);
    }

    public function store_financial_entry()
    {
        $coa_debit = $this->input->post('neraca_debit');
        $coa_kredit = $this->input->post('neraca_kredit');
        $nominal = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('input_nominal'));
        $keterangan = trim($this->input->post('input_keterangan'));
        $tanggal = $this->input->post('tanggal');
        $file = $_FILES['file_upload']['name'];
        $upload_path = ($file) ? base_url() . 'assets/img/financial_entry/' : '';

        $max_num = $this->m_invoice->select_max_fe();
        $bilangan = $max_num['max'] ? $max_num['max'] + 1 : 1;
        $no_urut = sprintf("%08d", $bilangan);
        $slug = "FE-" . $no_urut;

        if ($file) {
            $pathInfo = pathinfo($file);
            $extension = $pathInfo['extension'];
            $newFileName = $slug . '.' . $extension;

            $config = [
                'upload_path' => $upload_path,
                'allowed_types' => 'xls|xlsx',
                'overwrite' => TRUE,
                'file_name' => $newFileName,
            ];

            // echo "file ditemukan";
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_upload')) {
                $this->session->set_flashdata('message_error', 'Error message: ' . $this->upload->display_errors());
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        $data = [
            'coa_debit' => $coa_debit,
            'coa_kredit' => $coa_kredit,
            'nominal' => $nominal,
            'keterangan' => $keterangan,
            'tanggal_transaksi' => $tanggal,
            'file_path' => isset($file) ? $upload_path : null,
            'created_by' => $this->session->userdata('nip'),
            'slug' => $slug,
            'no_urut' => $bilangan
        ];
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;

        $this->m_invoice->add_fe($data);
        $this->session->set_flashdata('message_name', 'Financial entry berhasil ditambahkan. Status: Menunggu approval.');
        redirect('financial/financial_entry');
    }

    public function fe_pending()
    {
        $keyword = trim($this->input->post('keyword', true) ?? '');

        $config = [
            'base_url' => site_url('financial/fe_pending'),
            'total_rows' => $this->m_invoice->fe_pending_count($keyword),
            'per_page' => 20,
            'uri_segment' => 3,
            'num_links' => 10,
            'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
            'full_tag_close' => '</ul>',
            'first_link' => false,
            'last_link' => false,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'prev_link' => '«',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '»',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        ];

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $fes = $this->m_invoice->list_fe_pending($config["per_page"], $page, $keyword);

        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $result = $query->row_array()['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array()['COUNT(id)'];

        $data = [
            'page' => $page,
            'fes' => $fes,
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'coa' => $this->m_coa->list_coa(),
            'keyword' => $keyword,
            'title' => "FE Pending",
            'pages' => "pages/financial/v_fe_pending"
        ];

        $this->load->view('index', $data);
    }

    public function approve_fe($slug)
    {
        $nip = $this->session->userdata('nip');
        // print_r($slug);
        // exit;
        $fe = $this->m_invoice->detail_fe($slug);
        $coa_debit = "13010";
        $coa_kredit = "41101";

        $keterangan = $fe['keterangan'];
        $nominal = $fe['nominal'];
        $tanggal_transaksi = $fe['tanggal_transaksi'];
        $coa_debit = $fe['coa_debit'];
        $coa_kredit = $fe['coa_kredit'];

        // print_r($coa_debit);
        // exit;

        $this->posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal_transaksi);

        $data = [
            'status_approval' => '1',
            'approve_at' => date('Y-m-d H:i:s'),
            'approve_by' => $nip,
        ];

        $this->m_invoice->update_fe($data, $slug);

        $this->session->set_flashdata('message_name', 'Financial entry telah disetujui!');

        redirect('financial/fe_pending');
    }

    public function reject_fe($slug)
    {
        $nip = $this->session->userdata('nip');
        // print_r($slug);
        if (!$this->input->post('alasan_ditolak')) {
            redirect('financial/fe_pending');
        } else {
            $data = [
                'status_approval' => '2',
                'alasan_ditolak' => trim($this->input->post('alasan_ditolak')),
                'rejected_at' => date('Y-m-d H:i:s'),
                'rejected_by' => $nip,
            ];

            $this->m_invoice->update_fe($data, $slug);

            $this->session->set_flashdata('message_name', 'Financial entry telah ditolak!');

            redirect('financial/fe_pending');
        }
    }

    public function process_financial_entry()
    {
        $coa_debit = $this->input->post('neraca_debit');
        $coa_kredit = $this->input->post('neraca_kredit');

        $nominal = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('input_nominal'));
        $keterangan = trim($this->input->post('input_keterangan'));
        $tanggal = $this->input->post('tanggal');

        if (!$this->input->post()) {
            $this->session->set_flashdata('message_error', 'Gagal Input');
        } else {
            $this->posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal);

            $this->session->set_flashdata('message_name', 'Financial entry success.');
        }


        redirect('financial/financial_entry');
    }

    public function invoice()
    {
        $keyword = trim($this->input->post('keyword', true) ?? '');

        $config = [
            'base_url' => site_url('financial/invoice'),
            'total_rows' => $this->m_invoice->invoice_count($keyword),
            'per_page' => 20,
            'uri_segment' => 3,
            'num_links' => 10,
            'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
            'full_tag_close' => '</ul>',
            'first_link' => false,
            'last_link' => false,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'prev_link' => '«',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '»',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        ];

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $invoices = $this->m_invoice->list_invoice($config["per_page"], $page, $keyword);

        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $result = $query->row_array()['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array()['COUNT(id)'];

        $data = [
            'page' => $page,
            'invoices' => $invoices,
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'coa' => $this->m_coa->list_coa(),
            'coa_kas' => $this->m_coa->getCoaByCode('1201'),
            'coa_pendapatan' => $this->m_coa->getCoaByCode('410'),
            'keyword' => $keyword,
            'title' => "Invoice",
            'pages' => "pages/financial/v_invoice"
        ];

        $this->load->view('index', $data);
    }

    public function create_invoice()
    {
        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $res2 = $query->result_array();
        $result = $res2[0]['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $res2 = $query2->result_array();
        $result2 = $res2[0]['COUNT(id)'];

        $max_num = $this->m_invoice->select_max();

        if (!$max_num['max']) {
            $bilangan = 1; // Nilai Proses
        } else {
            $bilangan = $max_num['max'] + 1;
        }

        $no_inv = sprintf("%06d", $bilangan);

        $data = [
            'title' => 'Create Invoice',
            'no_invoice' => $no_inv,
            'customers' => $this->M_Customer->list_customer('reguler'),
            'pendapatan' => $this->m_coa->getCoaByCode('410'),
            'persediaan' => $this->m_coa->getCoaByCode('140'),
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        // $this->load->view('invoice_create', $data);
        $data['title'] = "Invoice";
        $data['pages'] = "pages/financial/v_invoice_create";

        $this->load->view('index', $data);
    }

    public function create_invoice_khusus()
    {
        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $res2 = $query->result_array();
        $result = $res2[0]['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $res2 = $query2->result_array();
        $result2 = $res2[0]['COUNT(id)'];

        $max_num = $this->m_invoice->select_max();

        if (!$max_num['max']) {
            $bilangan = 1; // Nilai Proses
        } else {
            $bilangan = $max_num['max'] + 1;
        }

        $no_inv = sprintf("%06d", $bilangan);

        $data = [
            'title' => 'Create Invoice',
            'no_invoice' => $no_inv,
            'customers' => $this->M_Customer->list_customer('khusus'),
            'pendapatan' => $this->m_coa->getCoaByCode('410'),
            'persediaan' => $this->m_coa->getCoaByCode('140'),
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        $this->load->view('invoice_create_khusus', $data);
    }

    public function store_invoice()
    {
        $id_user = $this->session->userdata('nip');
        $diskon = $this->input->post('diskon');
        $ppn = $this->input->post('ppn');
        $nominal = $this->convertToNumber($this->input->post('nominal'));
        $besaran_diskon = $this->convertToNumber($this->input->post('besaran_diskon'));
        $besaran_ppn = $this->convertToNumber($this->input->post('besaran_ppn'));
        $besaran_pph = $this->convertToNumber($this->input->post('besaran_pph'));
        $total_nonpph = $this->convertToNumber($this->input->post('total_nonpph'));
        $total_denganpph = $this->convertToNumber($this->input->post('total_denganpph'));
        $nominal_pendapatan = $this->convertToNumber($this->input->post('nominal_pendapatan'));
        $nominal_bayar = $this->convertToNumber($this->input->post('nominal_bayar'));
        $biaya_loading = $this->convertToNumber($this->input->post('biaya_loading'));
        $bruto = $this->convertToNumber($this->input->post('bruto'));
        $no_inv = $this->input->post('no_invoice');
        $opsi_termin = $this->input->post('opsi_termin');
        $opsi_pph = $this->input->post('opsi_pph');

        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        // exit;
        $pph = isset($opsi_pph) ? '0.02' : 0;
        $ppn = '0.11';

        $tgl_invoice = $this->input->post('tgl_invoice');

        $keterangan = trim($this->input->post('keterangan'));

        // Insert ke tabel invoice
        $invoice_data = [
            'no_invoice' => $no_inv,
            'tanggal_invoice' => $tgl_invoice,
            'created_by' => $id_user,
            'keterangan' => $keterangan,
            'id_customer' => $this->input->post('customer'),
            'subtotal' => $nominal,
            'diskon' => isset($diskon) ? $diskon : '0',
            'besaran_diskon' => $besaran_diskon,
            'ppn' => $ppn,
            'besaran_ppn' => $besaran_ppn,
            'opsi_pph23' => isset($opsi_pph) ? $opsi_pph : '0',
            'pph' => $pph,
            'besaran_pph' => $besaran_pph,
            'total_nonpph' => $total_nonpph,
            'total_denganpph' => $total_denganpph,
            'nominal_pendapatan' => $nominal_pendapatan,
            'nominal_bayar' => $nominal_bayar,
            'biaya_loading' => $biaya_loading,
            'bruto' => $bruto,
            'opsi_termin' => isset($opsi_termin) ? $opsi_termin : '0',
            'status_pendapatan' => '1'
        ];

        // echo '<pre>';
        // print_r($invoice_data);
        // echo '</pre>';
        // exit;

        $id_invoice = $this->m_invoice->insert($invoice_data);

        $items = $this->input->post('item');
        // $item_dates = $this->input->post('item_date');
        $qtys = $this->input->post('qty');
        $hargas = $this->input->post('harga');
        $total_amounts = $this->input->post('total_amount');

        $detail_data = [];

        if (is_array($items)) {
            for ($i = 0; $i < count($items); $i++) {
                $item = trim($items[$i]);
                $harga = $this->convertToNumber($hargas[$i]);
                $qty = $this->convertToNumber($qtys[$i]);
                $total_amount = $this->convertToNumber($total_amounts[$i]);

                $detail_data[] = [
                    'id_invoice' => $id_invoice,
                    'item' => $item,
                    'qty' => $qty,
                    'harga' => $harga,
                    'total_amount' => $total_amount,
                    'created_by' => $id_user
                ];
            }

            if (!empty($detail_data)) {
                $insert = $this->m_invoice->insert_batch($detail_data);

                if ($insert) {
                    // Jurnal 1: 13010 - Piutang Usaha bertambah (pendapatan), 41101 - PAD-Operasional Lainnya bertambah sebesar pendapatan
                    // $coa_debit = "13010";
                    // $coa_kredit = "41101";

                    // $this->posting($coa_debit, $coa_kredit, $keterangan, $total_denganpph, $tgl_invoice);

                    $this->session->set_flashdata('message_name', 'The invoice has been successfully created. ' . $no_inv);
                    // After that you need to used redirect function instead of load view such as 
                    redirect("financial/invoice");
                }
            }
        }
        // echo '<pre>';
        // print_r($detail_data);
        // echo '</pre>';
        // exit;
    }

    private function posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal)
    {
        $substr_coa_debit = substr($coa_debit, 0, 1);
        $substr_coa_kredit = substr($coa_kredit, 0, 1);

        $debit = $this->m_coa->cek_coa($coa_debit);
        $kredit = $this->m_coa->cek_coa($coa_kredit);

        $saldo_debit_baru = 0;
        $saldo_kredit_baru = 0;

        if ($debit['posisi'] == "AKTIVA") {
            $saldo_debit_baru = $debit['nominal'] + $nominal;
        } else if ($debit['posisi'] == "PASIVA") {
            $saldo_debit_baru = $debit['nominal'] - $nominal;
        }

        if ($kredit['posisi'] == "AKTIVA") {
            $saldo_kredit_baru = $kredit['nominal'] - $nominal;
        } else if ($kredit['posisi'] == "PASIVA") {
            $saldo_kredit_baru = $kredit['nominal'] + $nominal;
        }

        // cek tabel
        if ($substr_coa_debit == "1" || $substr_coa_debit == "2" || $substr_coa_debit == "3") {
            $tabel_debit = "t_coa_sbb";
            $kolom_debit = "no_sbb";
        } else {
            $tabel_debit = "t_coalr_sbb";
            $kolom_debit = "no_lr_sbb";
        }

        if ($substr_coa_kredit == "1" || $substr_coa_kredit == "2" || $substr_coa_kredit == "3") {
            $tabel_kredit = "t_coa_sbb";
            $kolom_kredit = "no_sbb";
        } else {
            $tabel_kredit = "t_coalr_sbb";
            $kolom_kredit = "no_lr_sbb";
        }

        $data_debit = [
            'nominal' => $saldo_debit_baru
        ];
        $data_kredit = [
            'nominal' => $saldo_kredit_baru
        ];

        $this->m_coa->update_nominal_coa($coa_debit, $data_debit, $kolom_debit, $tabel_debit);

        $this->m_coa->update_nominal_coa($coa_kredit, $data_kredit, $kolom_kredit, $tabel_kredit);

        $dt_jurnal = [
            'tanggal' => $tanggal,
            'akun_debit' => $coa_debit,
            'jumlah_debit' => $nominal,
            'akun_kredit' => $coa_kredit,
            'jumlah_kredit' => $nominal,
            'saldo_debit' => $saldo_debit_baru,
            'saldo_kredit' => $saldo_kredit_baru,
            'keterangan' => $keterangan,
            'created_by' => $this->session->userdata('nip'),
        ];

        $this->m_coa->addJurnal($dt_jurnal);

        $data_transaksi = [
            'user_id' => $this->session->userdata('nip'),
            'tgl_trs' => date('Y-m-d H:i:s'),
            'nominal' => $nominal,
            'debet' => $coa_debit,
            'kredit' => $coa_kredit,
            'keterangan' => trim($keterangan)
        ];

        $this->m_coa->add_transaksi($data_transaksi);
    }

    public function print_invoice($no_inv)
    {
        $inv =  $this->m_invoice->show($no_inv);
        $data = [
            'title_pdf' => 'Invoice No. ' . $no_inv,
            'invoice' => $inv,
            'details' => $this->m_invoice->item_list($inv['Id']),
            'user' => $this->m_invoice->cek_user($inv['user_create'])
        ];

        // filename dari pdf ketika didownload
        $file_pdf = 'Invoice No. ' . $no_inv;

        // setting paper
        $paper = 'A4';

        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('pages/financial/v_invoice_pdf', $data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function autocomplete()
    {
        $term = $this->input->get('term');
        $this->cb->like('nama_item', $term);
        $query = $this->cb->get('item_invoice');
        $result = $query->result_array();
        $items = [];
        foreach ($result as $row) {
            $items[] = [
                'label' => $row['nama_item'],
                'value' => $row['nama_item'],
                'id_item' => $row['id'],
                'harga' => $row['harga']
            ];
        }
        echo json_encode($items);
    }

    public function paid()
    {
        $no_inv = $this->uri->segment(3);

        $inv =  $this->m_invoice->show($no_inv);
        $coa_kas = $this->input->post('no_coa');
        $nominal_bayar = $this->convertToNumber(($this->input->post('nominal_bayar')));
        $keterangan = $this->input->post('keterangan');
        $status_bayar = $this->input->post('status_bayar');
        $coa_pendapatan = $this->input->post('coa_pendapatan');
        $tanggal_bayar = $this->input->post('tanggal_bayar');

        // var_dump($inv['bruto'], $inv['total_denganpph'], $inv['besaran_ppn'], $nominal_j2);
        // exit;

        // Versi SLS
        // J1: Kas/Bank bertambah sebesar besaran_ppn, PPn Keluaran bertambah sebesar besaran_ppn
        $j1_coa_debit = $coa_kas;
        $j1_coa_kredit = "23011";
        $this->posting($j1_coa_debit, $j1_coa_kredit, $keterangan, $inv['besaran_ppn'], $tanggal_bayar);

        // J2: Kas/Bank bertambah sebesar nominal_pendapatan, PPn Keluaran bertambah sebesar nominal_pendapatan
        $j2_coa_debit = $coa_kas;
        $j2_coa_kredit = $coa_pendapatan;
        $this->posting($j2_coa_debit, $j2_coa_kredit, $keterangan, $inv['nominal_pendapatan'], $tanggal_bayar);
        // print_r($status_bayar);
        // exit;

        // Versi jika menjadi PAD saat pembuatan invoice
        // // J1: PAD berkurang sebesar nominal pendapatan, Pendapatan bertambah sebesar nominal pendapatan
        // $j1_coa_debit = "41101";
        // $j1_coa_kredit = $coa_pendapatan;
        // $this->posting($j1_coa_debit, $j1_coa_kredit, $keterangan, $inv['nominal_pendapatan'], $tanggal_bayar);

        // // J2: Kas/Bank bertambah sebesar ppn, ppn keluaran bertambah sebesar ppn
        // $j2_coa_debit = $coa_kas;
        // $j2_coa_kredit = "23011";
        // $this->posting($j2_coa_debit, $j2_coa_kredit, $keterangan, $inv['besaran_ppn'], $tanggal_bayar);

        // // J3: Kas/Bank bertambah sebesar nominal bayar, piutang usaha berkurang sebesar nominal bayar
        // $j3_coa_debit = $coa_kas;
        // $j3_coa_kredit = "13010";
        // $this->posting($j3_coa_debit, $j3_coa_kredit, $keterangan, $inv['bruto'], $tanggal_bayar);

        if ($inv['opsi_pph23'] != '1') {
            // Apabila opsi potong pph23 tidak dicentang, maka akan terjadi jurnal di bawah ini
            // J4: Kas/Bank bertambah sebesar pph, utang pph 23 bertambah sebesar pph
            $j4_coa_debit = $coa_kas;
            $j4_coa_kredit = "23014";
            $this->posting($j4_coa_debit, $j4_coa_kredit, $keterangan, $inv['besaran_pph'], $tanggal_bayar);
        }

        $this->log_pembayaran("invoice", $inv['Id'], $nominal_bayar, $keterangan);

        $data_invoice = [
            'status_pendapatan' => ($status_bayar == 1) ? '2' : '1',
            'status_bayar' => ($status_bayar == 1) ? '1' : '0',
            'total_termin' => $inv['total_termin'] + $nominal_bayar,
            'tanggal_bayar' => $tanggal_bayar,
        ];

        $this->m_invoice->update_invoice($inv['Id'], $data_invoice);

        $this->session->set_flashdata('message_name', 'The invoice has been successfully updated. ' . $no_inv);
        // After that you need to used redirect function instead of load view such as 
        redirect("financial/invoice");
    }

    public function showReport()
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        $jenis_laporan = $this->input->post('jenis_laporan');

        if ($jenis_laporan) {
            if ($jenis_laporan == "neraca") {
                $this->prepareNeracaReport($data);
            } else if ($jenis_laporan == "laba_rugi") {
                $this->prepareLabaRugiReport($data);
            }
        } else {
            $this->prepareNeracaReport($data);
        }
    }

    public function showNeracaTersimpan($id)
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $detail = $this->m_coa->showNeraca($id);

        $data = [
            'title' => 'Neraca tersimpan',
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'pages' => 'pages/financial/v_neraca',
            'activa' => json_decode($detail['aktiva']),
            'pasiva' => json_decode($detail['pasiva']),
            'neraca' => $detail['nominal_sum_aktiva'] - $detail['nominal_sum_pasiva'],
            'sum_activa' => $detail['nominal_sum_aktiva'],
            'sum_pasiva' => $detail['nominal_sum_pasiva'],
            'laba' => $detail['nominal_laba_th_berjalan']
        ];

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;

        $this->load->view('index', $data);
    }

    public function showLRTersimpan($id)
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $detail = $this->m_coa->showNeraca($id);

        $data = [
            'title' => 'L/R tersimpan',
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'pages' => 'pages/financial/v_labarugi',
            'pendapatan' => json_decode($detail['pendapatan']),
            'biaya' => json_decode($detail['biaya']),
            'neraca' => $detail['nominal_sum_aktiva'] - $detail['nominal_sum_pasiva'],
            'sum_pendapatan' => $detail['nominal_sum_pendapatan'],
            'sum_biaya' => $detail['nominal_sum_biaya'],
            'selisih' => $detail['nominal_selisih']
        ];

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;

        $this->load->view('index', $data);
    }

    public function coa_report()
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'coas' => $this->m_coa->list_coa(),
        ];

        $no_coa = $this->input->post('no_coa');


        if ($no_coa) {
            $this->prepareCoaReport($data, $no_coa);
        } else {
            $data['title'] = "Report CoA";
            $data['pages'] = "pages/financial/v_report_per_coa";

            $this->load->view('index', $data);
        }
    }

    private function prepareNeracaReport(&$data)
    {
        $data['activa'] = $this->m_coa->getNeraca('t_coa_sbb', 'AKTIVA');
        $data['pasiva'] = $this->m_coa->getPasivaWithLaba('t_coa_sbb');

        $total_pasiva = array_sum(array_column($data['pasiva'], 'nominal'));
        $data['pendapatan'] = $this->m_coa->getSumNeraca('t_coalr_sbb', 'PASIVA')['nominal'];
        $data['beban'] = $this->m_coa->getSumNeraca('t_coalr_sbb', 'AKTIVA')['nominal'];

        $data['laba'] = $data['pendapatan'] - $data['beban'];
        $data['sum_activa'] = $this->m_coa->getSumNeraca('t_coa_sbb', 'AKTIVA')['nominal'];
        $data['sum_pasiva'] = $data['laba'] + $total_pasiva;
        $data['neraca'] = $data['sum_pasiva'] - $data['sum_activa'];

        // $this->load->view('neraca', $data);
        $data['title'] = "Neraca";
        $data['pages'] = "pages/financial/v_neraca";

        $this->load->view('index', $data);
    }

    private function prepareLabaRugiReport(&$data)
    {
        $data['biaya'] = $this->m_coa->getNeraca('t_coalr_sbb', 'AKTIVA');
        $data['pendapatan'] = $this->m_coa->getNeraca('t_coalr_sbb', 'PASIVA');

        $data['sum_biaya'] = $this->m_coa->getSumNeraca('t_coalr_sbb', 'AKTIVA')['nominal'];
        $data['sum_pendapatan'] = $this->m_coa->getSumNeraca('t_coalr_sbb', 'PASIVA')['nominal'];

        // $this->load->view('laba_rugi', $data);
        $data['title'] = "Laba rugi";
        $data['pages'] = "pages/financial/v_labarugi";

        $this->load->view('index', $data);
    }

    private function prepareCoaReport(&$data, $no_coa)
    {
        $from = $this->input->post('tgl_dari');
        $to = $this->input->post('tgl_sampai');

        $data['coa'] = $this->m_coa->getCoaReport($no_coa, $from, $to);

        $data['sum_debit'] = array_sum(array_map(function ($sum) use ($no_coa) {
            return $sum->akun_debit == $no_coa ? $sum->jumlah_debit : 0;
        }, $data['coa']));

        $data['sum_kredit'] = array_sum(array_map(function ($sum) use ($no_coa) {
            return $sum->akun_kredit == $no_coa ? $sum->jumlah_kredit : 0;
        }, $data['coa']));

        $data['detail_coa'] = $this->m_coa->getCoa($no_coa);

        // $this->load->view('report_per_coa', $data);
        $data['title'] = $no_coa;
        $data['pages'] = "pages/financial/v_report_per_coa";

        $this->load->view('index', $data);
    }

    public function simpanNeraca()
    {
        // header('Content-Type: application/json');
        $nip = $this->session->userdata('nip');
        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        $this->prepareNeracaReport($data);

        $json_activa = json_encode($data['activa']);
        $json_pasiva = json_encode($data['pasiva']);

        $insert = [
            'tanggal_simpan' => date('Y-m-d H:i:s'),
            'jenis' => 'neraca',
            'aktiva' => $json_activa,
            'pasiva' => $json_pasiva,
            'nominal_pendapatan' => $data['pendapatan'],
            'nominal_beban' => $data['beban'],
            'nominal_laba_th_berjalan' => $data['laba'],
            'nominal_sum_aktiva' => $data['sum_activa'],
            'nominal_sum_pasiva' => $data['sum_pasiva'],
            'nominal_selisih' => $data['neraca'],
            'created_by' => $this->session->userdata('nip'),
        ];

        if ($this->m_coa->simpanLaporan($insert)) {
            $this->session->set_flashdata('message_name', 'Laporan neraca berhasil disimpan.');
        } else {
            $this->session->set_flashdata('message_error', 'Laporan neraca gagal tersimpan.');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function simpanLR()
    {
        // header('Content-Type: application/json');
        $nip = $this->session->userdata('nip');
        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        $this->prepareLabaRugiReport($data);

        $json_biaya = json_encode($data['biaya']);
        $json_pendapatan = json_encode($data['pendapatan']);
        $selisih = $data['sum_pendapatan'] - $data['sum_biaya'];

        $insert = [
            'tanggal_simpan' => date('Y-m-d H:i:s'),
            'jenis' => 'labarugi',
            'biaya' => $json_biaya,
            'pendapatan' => $json_pendapatan,
            'nominal_sum_biaya' => $data['sum_biaya'],
            'nominal_sum_pendapatan' => $data['sum_pendapatan'],
            'nominal_selisih' => $selisih,
            'created_by' => $this->session->userdata('nip'),
        ];

        if ($this->m_coa->simpanLaporan($insert)) {
            $this->session->set_flashdata('message_name', 'Laporan laba rugi berhasil disimpan.');
        } else {
            $this->session->set_flashdata('message_error', 'Laporan laba rugi gagal tersimpan.');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function neraca_tersimpan()
    {
        $keyword = trim($this->input->post('keyword', true) ?? '');

        $config = [
            'base_url' => site_url('financial/neraca_tersimpan'),
            'total_rows' => $this->m_coa->count_laporan('neraca'),
            'per_page' => 20,
            'uri_segment' => 3,
            'num_links' => 10,
            'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
            'full_tag_close' => '</ul>',
            'first_link' => false,
            'last_link' => false,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'prev_link' => '«',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '»',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        ];

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $neraca = $this->m_coa->list_laporan('neraca', $config["per_page"], $page);

        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $result = $query->row_array()['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array()['COUNT(id)'];

        $data = [
            'page' => $page,
            'neraca' => $neraca,
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'coa' => $this->m_coa->list_coa(),
            'keyword' => $keyword,
            'title' => "Neraca tersimpan",
            'pages' => "pages/financial/v_neraca_tersimpan"
        ];

        $this->load->view('index', $data);
    }

    public function lr_tersimpan()
    {
        $keyword = trim($this->input->post('keyword', true) ?? '');

        $config = [
            'base_url' => site_url('financial/laba_tersimpan'),
            'total_rows' => $this->m_coa->count_laporan('labarugi'),
            'per_page' => 20,
            'uri_segment' => 3,
            'num_links' => 10,
            'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
            'full_tag_close' => '</ul>',
            'first_link' => false,
            'last_link' => false,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'prev_link' => '«',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '»',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        ];

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $neraca = $this->m_coa->list_laporan('labarugi', $config["per_page"], $page);

        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $result = $query->row_array()['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array()['COUNT(id)'];

        $data = [
            'page' => $page,
            'neraca' => $neraca,
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'coa' => $this->m_coa->list_coa(),
            'keyword' => $keyword,
            'title' => "L/R tersimpan",
            'pages' => "pages/financial/v_lr_tersimpan"
        ];

        $this->load->view('index', $data);
    }


    function convertToNumber($formattedNumber)
    {
        // Mengganti titik sebagai pemisah ribuan dengan string kosong
        $numberWithoutThousandsSeparator = str_replace('.', '', $formattedNumber);

        // Mengganti koma sebagai pemisah desimal dengan titik
        $standardNumber = str_replace(',', '.', $numberWithoutThousandsSeparator);

        // Mengonversi string ke float
        return (float) $standardNumber;
    }

    private function log_pembayaran($jenis, $id_invoice, $nominal, $keterangan)
    {
        $data = [
            'kategori_pembayaran' => $jenis,
            'id_invoice' => $id_invoice,
            'nominal_bayar' => $nominal,
            'keterangan' => $keterangan,
            'user_input' => $this->session->userdata('nip'),
        ];

        $this->m_invoice->addLogPayment($data);
    }

    public function void_invoice()
    {
        $no_inv = $this->uri->segment(3);

        $inv =  $this->m_invoice->show($no_inv);
        $coa_persediaan = $inv['coa_persediaan'];
        $jenis = $inv['jenis_invoice'];
        $keterangan = $this->input->post('keterangan');
        $total_biaya = $inv['total_biaya'];
        $nominal_pendapatan = $inv['nominal_pendapatan'];
        $tgl_void = date('Y-m-d');

        $data_void = [
            'status_void' => '1',
            'alasan_void' => $keterangan,
            'tanggal_void' => $tgl_void
        ];

        if ($inv) {
            // update 24 Juni 2024 jam 17:07
            // Jurnal 1: Persediaan (sesuai pilihan) bertambah sebesar total_biaya, 13010 - Piutang Usaha berkurang (dari total_biaya)
            $coa_debit = $coa_persediaan;
            $coa_kredit = ($jenis == "khusus") ? "20509" : "13010";

            $this->posting($coa_debit, $coa_kredit, $keterangan, $total_biaya, $tgl_void);

            // Jurnal 2: 41101 - PAD-Operasional Lainnya berkurang sebesar pendapatan, 13010 - Piutang Usaha bertambah (pendapatan)
            $coa_debit = "41101";
            $coa_kredit = "13010";

            $this->posting($coa_debit, $coa_kredit, $keterangan, $nominal_pendapatan, $tgl_void);

            $this->m_invoice->update_invoice($inv['Id'], $data_void);

            $this->session->set_flashdata('message_name', 'The invoice has been successfully void. ' . $no_inv);
            // After that you need to used redirect function instead of load view such as 
            redirect("financial/invoice");
        }
    }
}
