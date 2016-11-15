@extends('home.index')

@section('content')
<div class="row">
  <div class="col s12 m12 l12">
    <div class="card-panel">
      <span>
        <div class="row">
          <div class="col s12 m6 offset-m3 l4" id="produto_img">
            <img style="width: 100%;" src="{{ $image }}">
          </div>
          <div class="col l8">
            <div class="">
              <div id="produto_cab">
                  <h5>{{ $product->name }}</h5>
                  @foreach ($tags as $tag)
                  <div class="chip">
                      {{ $tag }}
                  </div>
                  @endforeach

                  <!--<div style="position: absolute; bottom: 20%;">-->
                  <div>
                    <div class="flow-text">Valor novo: R$ {{ number_format($valor,2,",",".") }}</div>
                  </div>
              </div>

              <div id="produto_gra" style="width: 100%;">
                  <canvas id="grafico_linha"></canvas>
              </div>

              <!-- Corrige o tamanho do grafico-->
              <script>
                  function resize_chart() {
                      if ($(window).width()>992) {
                          height_chart = $("#produto_img").height()-$("#produto_cab").height()-20;
                      } else {
                          height_chart = 200;
                      }
                      $("#produto_gra").css("height",height_chart);
                  }

                  resize_chart();
                  $( window ).resize(function() {
                      resize_chart();
                  });
              </script>

              <!--  Script do grafico -->
              <script>
              var ctx = document.getElementById("grafico_linha");
              var grafico_linha = new Chart(ctx, {
                  type: 'line',
                  data: {
                    labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho"],
                    datasets: [
                        {
                            label: "Menor preço",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(75,192,192,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: [65, 59, 80, 81, 56, 55, 40],
                            spanGaps: false,
                        }
                    ]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      },
                      responsive: true,
                      maintainAspectRatio: false
                  }
              });
              </script>




            </div>
            <!--
            <div class="card-action">
              <a href="#"><i class="mdi mdi-heart mdi-24px"></i></a>
              <a href="#"><i class="mdi mdi-share-variant mdi-24px"></i></a>
            </div>
            -->
          </div>
        </div>
        <hr>
        <form action="#">
          <div class="row">
              <div class="col s12 l4">
                  <p class="range-field">
                     <label for="test5" style="position: absolute;">Estado</label>
                     <input type="range" id="test5" min="0" max="10" />
                  </p>
              </div>
              <div class="col s12 l4">
                  <select>
                    <option value="" disabled selected>Estado da tela</option>
                    <option value="1">Perfeita</option>
                    <option value="2">Pequenos riscos</option>
                    <option value="3">Vários riscos</option>
                    <option value="3">Tricada</option>
                  </select>
              </div>
              <div class="col s12 l4">
                <p>
                    <input type="checkbox" id="test5" />
                    <label for="test5" style="display: block;">Acessórios Originais</label>
                </p>
              </div>
              <!--
              <div class="col s12 l4">
                <input type="date" class="datepicker" placeholder="Data de compra">
              </div>
            -->
          </div>
          <div class="row">
              <div class="col s6 m6 l6">
                  <a class="waves-effect waves-light btn-large">Salvar</a>
              </div>
              <div class="col s6 m6 l6">

              </div>
          </div>
        </form>
      </span>
    </div>
  </div>
</div>
@endsection
