<div class="container row">
    <div class="form-group col-lg-4">
        <label for="periode">Periode Bulan</label>
        <input type="date" class="form-control" name="periode" id="periode">
    </div>
    <div class="form-group col-lg-4"><label for="kdgudang">Kode Gudang</label>
        <select name="kdgudang" id="kdgudang" class="form-control" nama="kdgudang">
            <option value="G113">G113 GUDANG INDUK</option>
            <option value="G140">G140 DEPO PERISHABLE BGR2</option>
            <option value="G128">G128 DEPO SUKABUMI</option>
        </select>
    </div>
    <div class="class-form-group col-lg-4">
        <br>
        <button id="btncek" class="btn btn-lg btn-primary ">CEK</button>
    </div>

</div>
<div class="container">
    <div id="hasil"></div>

</div>
<script src="<?= base_url('appjs/checklist.js') ?>"></script>