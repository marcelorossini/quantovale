@extends('home.index')

@section('content')
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8&appId=689783111181648";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<script>
var nResult = 0;
</script>

<div class="card-panel">
  <div class="row">
    <!-- Imagem do produto -->
    <div class="col s12 m6 offset-m3 l4" id="produto_img">
      <img style="width: 100%;" src="{{ $image }}">
    </div>
    <!-- Dados do produto -->
    <div class="col s12 m12 l8">
      <div class="">
        <div id="produto_cab">
          <h4>{{ $aProduct->name }}</h4>
          @foreach ($aTags as $tag)
          <div class="chip">
            {{ $tag }}
          </div>
          @endforeach

          <!--<div style="position: absolute; bottom: 20%;">-->
          <div>
            <div class="flow-text">Valor novo: R$ {{ number_format($nValorNovo,2,",",".") }}</div>
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
            labels: JSON.parse('{!! json_encode($aChart[0]) !!}'),
            datasets: [
              {
                label: "Menor preço",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(79,195,247,0.4)",
                borderColor: "rgba(79,195,247,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(79,195,247,1)",
                pointBackgroundColor: "rgba(79,195,247,1)",
                pointBorderWidth: 5,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(79,195,247,1)",
                pointHoverBorderColor: "rgba(79,195,247,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: JSON.parse('{!! json_encode($aChart[1]) !!}'),
                spanGaps: false,
              },
              {
                label: "Maior preço",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(239,83,80,0.4)",
                borderColor: "rgba(239,83,80,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(239,83,80,1)",
                pointBackgroundColor: "rgba(239,83,80,1)",
                pointBorderWidth: 5,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(239,83,80,1)",
                pointHoverBorderColor: "rgba(239,83,80,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: JSON.parse('{!! json_encode($aChart[2]) !!}'),
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
    </div>
  </div>
  <hr>
  <!-- Filtros -->
  <div class="row">
    <div class="col s12 m12 l4 filcal" id="divFilters">
      <form method="POST" action="{!! route('postResult',$aProduct->id) !!}" id="formFilters">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @foreach ($aFilters as $filter)
        {!! !$sNameField = $filter->type.'_'.$filter->id !!}
        @if ($filter->type === 'date')
        <div class="col s12 m12 l12">
          <label for="{{ $sNameField }}" style="position: relative; top: 8px;">{{ $filter->name }}</label>
          <input type="date" name="{{ $sNameField }}" id="{{ $sNameField }}" class="datepicker">
        </div>
        @elseif ($filter->type === 'range')
        <div class="col s12 m12 l12">
          <p class="range-field">
            <label for="{{ $sNameField }}" style="position: absolute; top: -25px;">{{ $filter->name }}</label>
            <input type="range" name="{{ $sNameField }}" id="{{ $sNameField }}" min="0" max="10" value="10"/>
          </p>
        </div>
        @elseif ($filter->type === 'check')
        <div class="col s12 m12 l12">
          <p>
            <input type="checkbox" name="{{ $sNameField }}" {{ $filter->default }} id="{{ $sNameField }}"/>
            <label for="{{ $sNameField }}" style="display: block;">{{ $filter->name }}</label>
          </p>
        </div>
        @elseif ($filter->type === 'select')
        <div class="col s12 m12 l12">
          <select>
            <option value="" disabled selected>{{ $filter->name }}</option>
            <option value="1">Perfeita</option>
            <option value="2">Pequenos riscos</option>
            <option value="3">Vários riscos</option>
            <option value="3">Tricada</option>
          </select>
        </div>
        @endif
        @endforeach
        <button type="submit" id="btnFormCalcular" style="display: none;"></button>
      </form>
    </div>
    <div class="col s12 m12 l8 filcal valign-wrapper center-align" id="divCalculo">
      <div class="col s12 m12 l12" style="">
        <div id="divRetornoCalculo" style="display: none;">
          <div class="flow-text">
            Seu produto vale:
            <div id="divValorCalculado"></div>
          </div>
          <!-- SALVAR -->
          <a class="tooltipped" id="btnFormResultSave" data-position="bottom" data-delay="50" data-tooltip="Gostei <3"><i class="mdi mdi-heart"></i>  <!-- bell --></a>
          <script>
          $('#btnFormResultSave').click(function() {
            // Altera para salvo ou não
            $(this).toggleClass('active');
            // Variáveis auxiliares
            var bTrueFalse = $(this).hasClass('active');
            if (bTrueFalse == true) {
              Materialize.toast('Adicionado aos favoritos!', 3000);
            } else if (bTrueFalse == false) {
              Materialize.toast('Removido dos favoritos!', 3000);
            }
            var url = ('{!! route('postResultSave',[$aProduct->id,"nResult","bTrueFalse"]) !!}').replace('nResult',nResult);
            url = url.replace('bTrueFalse',bTrueFalse);
            var values = {'_token': '{{ csrf_token() }}'};
            $.ajax({
              url: url,
              type: "POST",
              data: values,
            });
          });
          </script>
          <!-- COMPARTILHAR -->
          <a class="tooltipped" onclick="$('#btnFormResultSave').trigger('click')" href="#modalCompartilhar" data-position="bottom" data-delay="50" data-tooltip="Compartilhar"><i class="mdi mdi-share"></i></a>
          <!-- RESTART -->
          <a class="tooltipped" onclick="location.reload()" data-position="bottom" data-delay="50" data-tooltip="Recalcular"><i class="mdi mdi-reload"></i></a>
        </div>

        <!-- Modal Structure -->
        <div id="modalCompartilhar" class="modal bottom-sheet">
          <div class="modal-content">
            <h4>Compartilhar</h4>
            <hr>
            <div class="row">
              <div class="col s4 m4 l1">
                <a id="facebook_share"><i class="mdi mdi-facebook-box color-facebook"></i><br><span>Facebook</span></a>
                <script>
                $('#facebook_share').click(function() {
                  FB.ui({
                    method: 'share',
                    href: ('{{ route("getShare","nResult") }}').replace('nResult',nResult)
                  }, function(response){});
                });
                </script>
              </div>
              <div class="col s4 m4 l1">
                <a href="#"><i class="mdi mdi-whatsapp color-whatsapp"></i><br><span>WhatsApp</span></a>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class=" modal-action modal-close waves-effect waves-green btn-flat">CANCELAR</a>
          </div>
        </div>
        <script>
        // Chama o modal de compartilhamento
        $(document).ready(function(){
          $('.modal').modal();
          $('.tooltipped').tooltip({delay: 50});
        });
        </script>
        <label class="waves-effect waves-light btn-large" for="btnFormCalcular" id="btnCalcular">Calcular</label>
      </div>
    </div>
    <!-- Corrige o tamanho do grafico-->
    <script>
    $(document).ready(function(){
      $('.filcal').matchHeight();
    });
    </script>
  </div>
  <!-- AJAX para enviar o formulário -->
  <script>
  $(document).ready(function() {
    $('#formFilters').ajaxForm({
      dataType:  'json',
      success:   processJson
    });
  });

  // Função de tratamento do retorno do JSON
  function processJson(data) {
    $("#btnCalcular").hide();
    $("#divFilters").hide();
    $("#divCalculo").removeClass("l8");
    $("#divCalculo").addClass("l12");
    $("#divRetornoCalculo").show();
    $('#divValorCalculado').html('R$ '+(data.valor).formatMoney(2, ',', '.'));

    //Atualiza variável de resultado
    nResult = data.result;
  }
  </script>
</div>
@endsection
