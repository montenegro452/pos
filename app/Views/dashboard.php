    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
              <div class="d-flex align-items-end flex-wrap">
                <div class="mr-md-3 mr-xl-5">
                  <h2><?= $title; ?></h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body dashboard-tabs p-0">
                <ul class="nav nav-tabs px-4" role="tablist">
                  <li class="nav-item">
                    <a
                      class="nav-link active"
                      id="overview-tab"
                      data-toggle="tab"
                      href="#overview"
                      role="tab"
                      aria-controls="overview"
                      aria-selected="true">Productos</a>
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      id="sales-tab"
                      data-toggle="tab"
                      href="#sales"
                      role="tab"
                      aria-controls="sales"
                      aria-selected="false">Ventas</a>
                  </li>
                </ul>
                <div class="tab-content py-0 px-0">
                  <div
                    class="tab-pane fade show active"
                    id="overview"
                    role="tabpanel"
                    aria-labelledby="overview-tab">
                    <div class="d-flex flex-wrap justify-content-xl-between">
                      <div
                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i
                          class="mdi mdi-package icon-lg mr-3 text-primary"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <small class="mb-1 text-muted">Total de Productos</small>
                          <h5 class="mr-2 mb-0"><?= $datos['total']; ?></h5>
                          <a class="small" href="<?= base_url(); ?>productos">Ver mas</a>
                        </div>
                      </div>
                      <div
                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i
                          class="mdi mdi-package-variant mr-3 icon-lg text-success"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <small class="mb-1 text-muted">Cant. de Productos vendidos</small>
                          <h5 class="mr-2 mb-0"><?= $datos['totalVendidos']; ?></h5>
                          <a class="small" href="<?= base_url(); ?>productos">Ver mas</a>
                        </div>
                      </div>
                      <div
                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i class=" mdi mdi-tag-outline mr-3 icon-lg text-danger"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <small class="mb-1 text-muted">Categorias de Productos</small>
                          <h5 class="mr-2 mb-0"><?= $datos['categorias']; ?></h5>
                          <a class="small" href="<?= base_url(); ?>categorias">Ver mas</a>
                        </div>
                      </div>
                      <div
                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i
                          class="mdi mdi-basket-fill mr-3 icon-lg text-warning"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <small class="mb-1 text-muted">Productos sin Stock</small>
                          <h5 class="mr-2 mb-0"><?= $datos['minimos']; ?></h5>
                          <a class="small" href="<?= base_url(); ?>productos/mostrarMinimos">Ver mas</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="sales"
                    role="tabpanel"
                    aria-labelledby="sales-tab">
                    <div class="d-flex flex-wrap justify-content-xl-between">
                      <div
                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i
                          class="mdi mdi-cart mr-3 icon-lg text-success"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <small class="mb-1 text-muted">Ventas del Dia</small>
                          <h5 class="mr-2 mb-0"><?= $datos['totalVentas']; ?></h5>
                          <a class="small" href="<?= base_url(); ?>ventas">Ver mas</a>
                        </div>
                      </div>
                      <div
                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i
                          class="mdi mdi-calendar-text mr-3 icon-lg text-info"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <small class="mb-1 text-muted">Ventas del Mes</small>
                          <h5 class="mr-2 mb-0"><?= $datos['totalVentasMes']; ?></h5>
                          <a class="small" href="<?= base_url(); ?>ventas">Ver mas</a>
                        </div>
                      </div>
                      <div
                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i
                          class="mdi mdi-download mr-3 icon-lg text-warning"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <small class="mb-1 text-muted">Downloads</small>
                          <h5 class="mr-2 mb-0">2233783</h5>
                        </div>
                      </div>
                      <div
                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i class="mdi mdi-eye mr-3 icon-lg text-success"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <small class="mb-1 text-muted">Total views</small>
                          <h5 class="mr-2 mb-0">9833550</h5>
                        </div>
                      </div>
                      <div
                        class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i
                          class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <small class="mb-1 text-muted">Revenue</small>
                          <h5 class="mr-2 mb-0">$577545</h5>
                        </div>
                      </div>
                      <div
                        class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <small class="mb-1 text-muted">Flagged</small>
                          <h5 class="mr-2 mb-0">3497843</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-title">Ventas diarias</p>
                <div
                  id="cash-deposits-chart-legend"
                  class="d-flex justify-content-center pt-3"></div>
                <canvas id="cash-deposits-chart"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-title">Total sales</p>
                <h1>$ 28835</h1>
                <h4>Gross sales over the years</h4>
                <p class="text-muted">
                  Today, many people rely on computers to do homework, work, and
                  create or store useful information. Therefore, it is important
                </p>
                <div id="total-sales-chart-legend"></div>
              </div>
              <canvas id="total-sales-chart"></canvas>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
      <!-- partial:partials/_footer.html -->
    </div>
    </div>
    </div>