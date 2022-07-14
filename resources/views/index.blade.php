@section('js')

<script>
  var ctxpegawai = document.getElementById("pegawai").getContext("2d");
  var ctxbarang = document.getElementById("barang").getContext("2d");
  var ctxmodal = document.getElementById("modal").getContext("2d");

  new Chart(ctxpegawai, {
    type: "bar",
    data: {
      labels: ["2020", "2021", "2022"],
      datasets: [{
        label: "Total Pagu ",
        tension: 0,
        borderWidth: 10,
        pointRadius: 5,
        pointBackgroundColor: "rgba(255, 255, 255, .8)",
        pointBorderColor: "transparent",
        borderColor: "rgba(255, 255, 255, .8)",
        borderColor: "rgba(255, 255, 255, .8)",
        borderWidth: 4,
        backgroundColor: "orange",
        fill: false,
        data: [2590492906000, 1743638173000, 11820133400000],
        maxBarThickness: 35
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        }
      },
      interaction: {
        intersect: false,
        mode: 'index',
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5],
            color: 'rgba(255, 255, 255, .2)'
          },
          ticks: {
            display: true,
            color: '#f8f9fa',
            padding: 10,
            font: {
              size: 14,
              weight: 300,
              family: "Roboto",
              style: 'normal',
              lineHeight: 2
            },
          }
        },
        x: {
          grid: {
            drawBorder: false,
            display: false,
            drawOnChartArea: false,
            drawTicks: false,
            borderDash: [5, 5]
          },
          ticks: {
            display: true,
            color: '#f8f9fa',
            padding: 10,
            font: {
              size: 14,
              weight: 300,
              family: "Roboto",
              style: 'normal',
              lineHeight: 2
            },
          }
        },
      },
    },
  });

  new Chart(ctxbarang, {
    type: "line",
    data: {
      labels: ["2020", "2021", "2022"],
      datasets: [{
        label: "Mobile apps",
        tension: 0,
        borderWidth: 0,
        pointRadius: 5,
        pointBackgroundColor: "rgba(255, 255, 255, .8)",
        pointBorderColor: "transparent",
        borderColor: "rgba(255, 255, 255, .8)",
        borderColor: "rgba(255, 255, 255, .8)",
        borderWidth: 4,
        backgroundColor: "transparent",
        fill: true,
        data: [2590492906000, 1743638173000, 11820133400000],
        maxBarThickness: 6
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        }
      },
      interaction: {
        intersect: false,
        mode: 'index',
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5],
            color: 'rgba(255, 255, 255, .2)'
          },
          ticks: {
            display: true,
            color: '#f8f9fa',
            padding: 10,
            font: {
              size: 14,
              weight: 300,
              family: "Roboto",
              style: 'normal',
              lineHeight: 2
            },
          }
        },
        x: {
          grid: {
            drawBorder: false,
            display: false,
            drawOnChartArea: false,
            drawTicks: false,
            borderDash: [5, 5]
          },
          ticks: {
            display: true,
            color: '#f8f9fa',
            padding: 10,
            font: {
              size: 14,
              weight: 300,
              family: "Roboto",
              style: 'normal',
              lineHeight: 2
            },
          }
        },
      },
    },
  });

  new Chart(ctxmodal, {
    type: "line",
    data: {
      labels: ["2020", "2021", "2022"],
      datasets: [{
        label: "Mobile apps",
        tension: 0,
        borderWidth: 0,
        pointRadius: 5,
        pointBackgroundColor: "rgba(255, 255, 255, .8)",
        pointBorderColor: "transparent",
        borderColor: "rgba(255, 255, 255, .8)",
        borderColor: "rgba(255, 255, 255, .8)",
        borderWidth: 4,
        backgroundColor: "transparent",
        fill: true,
        data: [2590492906000, 1743638173000, 11820133400000],
        maxBarThickness: 6
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        }
      },
      interaction: {
        intersect: false,
        mode: 'index',
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5],
            color: 'rgba(255, 255, 255, .2)'
          },
          ticks: {
            display: true,
            color: '#f8f9fa',
            padding: 10,
            font: {
              size: 14,
              weight: 300,
              family: "Roboto",
              style: 'normal',
              lineHeight: 2
            },
          }
        },
        x: {
          grid: {
            drawBorder: false,
            display: false,
            drawOnChartArea: false,
            drawTicks: false,
            borderDash: [5, 5]
          },
          ticks: {
            display: true,
            color: '#f8f9fa',
            padding: 10,
            font: {
              size: 14,
              weight: 300,
              family: "Roboto",
              style: 'normal',
              lineHeight: 2
            },
          }
        },
      },
    },
  });
</script>

@stop
@section('css')
@stop

@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
  <div class="page-header min-height-300 border-radius-xl mt-0" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1920&amp;q=80');">
    <span class="mask bg-gradient-primary opacity-3"></span>
  </div>
  <div class="row mx-3 mx-md-4 mt-n10">
      <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">
                    <marquee scrollamount="5" style="font-size: 18px; line-height: 18px;">Nantikan Inovasi Terbaru Aplikasi Biro Perencanaan Mahkamah Agung RI</marquee>
                    <!--
                    {{ $config['pageTitle']  }}
                    -->
                  </h6>
                </div>
            </div>
            <div class="card-body my-3 p-3">
              <div class="row p-3">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                  <div class="card">
                    <div class="card-header p-3 pt-2">
                      <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">group_add</i>
                      </div>
                      <div class="text-end pt-4">
                        <p class="mt-0 mb-0 text-capitalize" style="font-size: 25px; line-height: 28px;">Belanja Pegawai</p>
                        <h4 class="mb-0" style="font-size: 30px;">Rp. 7.486.002.321.000</h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-">
                  <div class="card">
                    <div class="card-header p-3 pt-2">
                      <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">add_shopping_cart</i>
                      </div>
                      <div class="text-end pt-4">
                        <p class="mt-0 mb-0 text-capitalize" style="font-size: 25px; line-height: 28px;">Belanja Barang</p>
                        <h4 class="mb-0" style="font-size: 30px;">Rp. 2.590.492.906.000</h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                  <div class="card">
                    <div class="card-header p-3 pt-2">
                      <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">monetization_on</i>
                      </div>
                      <div class="text-end pt-4">
                        <p class="mt-0 mb-0 text-capitalize" style="font-size: 25px; line-height: 28px;">Belanja Modal</p>
                        <h4 class="mb-0" style="font-size: 30px;">Rp. 1.743.638.173.000</h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                  <div class="card">
                    <div class="card-header p-3 pt-2">
                      <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">monetization_on</i>
                      </div>
                      <div class="text-end pt-4">
                        <p class="mt-0 mb-0 text-capitalize" style="font-size: 25px; line-height: 28px;">Total Pagu</p>
                        <h4 class="mb-0" style="font-size: 30px;">Rp. 11.820.133.400.000</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <hr class="dark horizontal my-2">

              <div class="row p-3">
                  <div class="col-lg-4 col-md-6 mt-4 mb-0">
                    <div class="card z-index-2  ">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                          <div class="chart">
                            <canvas id="pegawai" class="chart-canvas" style="display: block; box-sizing: border-box; height: 170px; width: 457.2px;" width="498" height="185"></canvas>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <h6 class="mb-0 "> Statistik Belanja Pegawai 3 Tahun Terakhir </h6> 

                        <hr class="dark horizontal my-2">

                        <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tahun 2020
                            <span class="text-primary">Rp. 11.820.133.400.000</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tahun 2021
                            <span class="text-primary">Rp. 11.820.133.400.000</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tahun 2022
                            <span class="text-primary">Rp. 11.820.133.400.000</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-4 mb-0">
                    <div class="card z-index-2  ">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                          <div class="chart">
                            <canvas id="barang" class="chart-canvas" style="display: block; box-sizing: border-box; height: 170px; width: 457.2px;" width="498" height="185"></canvas>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <h6 class="mb-0 "> Statistik Belanja Barang 3 Tahun Terakhir </h6> 

                        <hr class="dark horizontal my-2">

                        <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tahun 2020
                            <span class="text-primary">Rp. 11.820.133.400.000</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tahun 2021
                            <span class="text-primary">Rp. 11.820.133.400.000</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tahun 2022
                            <span class="text-primary">Rp. 11.820.133.400.000</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-4 mb-0">
                    <div class="card z-index-2  ">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                          <div class="chart">
                            <canvas id="modal" class="chart-canvas" style="display: block; box-sizing: border-box; height: 170px; width: 457.2px;" width="498" height="185"></canvas>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <h6 class="mb-0 "> Statistik Belanja Modal 3 Tahun Terakhir </h6> 

                        <hr class="dark horizontal my-2">

                        <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tahun 2020
                            <span class="text-primary">Rp. 11.820.133.400.000</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tahun 2021
                            <span class="text-primary">Rp. 11.820.133.400.000</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tahun 2022
                            <span class="text-primary">Rp. 11.820.133.400.000</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection