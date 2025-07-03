<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <?= form_open('buy', 'class="row g-3"') ?>
        <?= form_hidden('username', session()->get('username')) ?>
        <?= form_input(['type' => 'hidden', 'name' => 'total_harga', 'id' => 'total_harga', 'value' => '']) ?>
        <?= form_input(['type' => 'hidden', 'name' => 'ppn', 'id' => 'ppn', 'value' => '']) ?>
        <?= form_input(['type' => 'hidden', 'name' => 'biaya_admin', 'id' => 'biaya_admin', 'value' => '']) ?>
        <?= form_input(['type' => 'hidden', 'name' => 'ongkir', 'id' => 'ongkir', 'value' => '']) ?>

        <div class="col-12">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" value="<?= session()->get('username'); ?>" readonly>
        </div>
        <div class="col-12">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div> 
        <div class="col-12">
            <label for="kelurahan" class="form-label">Kelurahan</label>
            <select class="form-control" id="kelurahan" name="kelurahan" required></select>
        </div>
        <div class="col-12">
            <label for="layanan" class="form-label">Layanan</label>
            <select class="form-control" id="layanan" name="layanan" required></select>
        </div>
        <div class="col-12">
            <label for="ongkir_view" class="form-label">Ongkir</label>
            <input type="text" class="form-control" id="ongkir_view" readonly value="IDR 0">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)) : foreach ($items as $item) : ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td><?= number_to_currency($item['price'], 'IDR') ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td><?= number_to_currency($item['price'] * $item['qty'], 'IDR') ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    <tr>
                        <td colspan="2"></td>
                        <td><strong>Subtotal</strong></td>
                        <td><?= number_to_currency($total, 'IDR') ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td>PPN (11%)</td>
                        <td><span id="ppn_view">IDR 0</span></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td>Biaya Admin</td>
                        <td><span id="admin_view">IDR 0</span></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td>Ongkir</td>
                        <td><span id="ongkir_text">IDR 0</span></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td><strong>Grand Total</strong></td>
                        <td><strong><span id="total">IDR <?= number_to_currency($total, 'IDR') ?></span></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
        </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    var subtotal = <?= $total ?>;
    var ongkir = 0;
    var ppn = 0;
    var admin = 0;
    var total = 0;

    hitungTotal();

    $('#kelurahan').select2({
        placeholder: 'Ketik nama kelurahan...',
        ajax: {
            url: '<?= base_url('get-location') ?>',
            dataType: 'json',
            delay: 1500,
            data: params => ({ search: params.term }),
            processResults: data => ({
                results: data.map(item => ({
                    id: item.id,
                    text: item.subdistrict_name + ", " + item.district_name + ", " + item.city_name + ", " + item.province_name + ", " + item.zip_code
                }))
            }),
            cache: true
        },
        minimumInputLength: 3
    });

    $("#kelurahan").on('change', function() {
        $("#layanan").empty();
        ongkir = 0;
        $.ajax({
            url: "<?= site_url('get-cost') ?>",
            type: 'GET',
            data: { destination: $(this).val() },
            dataType: 'json',
            success: function(data) {
                data.forEach(item => {
                    var text = item["description"] + " (" + item["service"] + ") : estimasi " + item["etd"];
                    $("#layanan").append(new Option(text, item["cost"]));
                });
                hitungTotal();
            }
        });
    });

    $("#layanan").on('change', function() {
        ongkir = parseInt($(this).val());
        hitungTotal();
    });

    function hitungTotal() {
        ppn = Math.round((subtotal + ongkir) * 0.11);

        if (subtotal <= 20000000) {
            admin = Math.round(subtotal * 0.006);
        } else if (subtotal <= 40000000) {
            admin = Math.round(subtotal * 0.008);
        } else {
            admin = Math.round(subtotal * 0.01);
        }

        total = subtotal + ongkir + ppn + admin;

        $("#ongkir_view").val(formatRupiah(ongkir));    
        $("#ongkir_text").html(formatRupiah(ongkir));  
        $("#ppn_view").html(formatRupiah(ppn));
        $("#admin_view").html(formatRupiah(admin));
        $("#total").html(formatRupiah(total));

        $("#ongkir").val(ongkir);
        $("#total_harga").val(total);
        $("#ppn").val(ppn);
        $("#biaya_admin").val(admin);
    }

    function formatRupiah(angka) {
        return 'IDR ' + angka.toLocaleString('id-ID');
    }
});
</script>
<?= $this->endSection() ?>

