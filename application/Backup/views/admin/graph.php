<style>
    .highlight-green {
        background-color: #0077C3;
        color: white;
    }
</style>
<form action="<?= base_url("set_adjust_otd"); ?>" id="form-adjust" method="post">
    <div class="row">
        <div class="col-lg-10"></div>
        <div class="col-lg-2">
            <p class="mb-1 mt-2">Periode</p>
            <input type="date" name="periodeGraph" id="periodeGraph" class="form-control" value="<?= $periodeGraph; ?>">
        </div>
    </div>
</form>
<div class="row mt-3">
    <div class="chart-container" style="width:100%; max-width:100%; height:47rem;">
        <canvas id="myChart" class="myChart" style="width:100% !important;"></canvas>
    </div>
    <div class="col-lg-12 text-right mt-3">
        <a href="<?= base_url(""); ?>" class="btn btn-sm btn-danger">Kembali</a>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-list-unit" tabindex="-1" aria-labelledby="modal-list-unitLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-list-unitLabel">Show List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center" id="list-unit">
        <i class="fas fa-spinner fa-spin" style="font-size:30pt;"></i>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>