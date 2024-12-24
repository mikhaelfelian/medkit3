<?php
class ObatModel extends BaseModel {
    protected $table = 'tbl_m_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_satuan',
        'id_kategori',
        'id_kategori_lab',
        'id_kategori_gol',
        'id_lokasi',
        'id_merk',
        'id_user',
        'tgl_simpan',
        'tgl_modif',
        'kode',
        'barcode',
        'item',
        'item_alias',
        'item_kand',
        'item_kand2',
        'jml',
        'jml_display',
        'jml_limit',
        'harga_beli',
        'subtotal',
        'harga_beli_ppn',
        'harga_jual',
        'harga_hasil',
        'harga_grosir',
        'remun_tipe',
        'remun_perc',
        'remun_nom',
        'apres_tipe',
        'apres_perc',
        'apres_nom',
        'status_promo',
        'status_subt',
        'status_lab',
        'status_brg_dep',
        'status_stok',
        'status_racikan',
        'status_etiket',
        'status_hps',
        'sl',
        'sp',
        'so',
        'status'
    ];

    protected $timestamps = false;
} 