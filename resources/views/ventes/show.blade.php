@extends('layouts.default')
@section('meta')
   <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
   <div class="invoice p-3 mb-3">
      <!-- title row -->
      <div class="row">
         <div class="col-12">
            <h4>
               <i class="fas fa-globe"></i> Hotel, Inc.
               <small class="float-right">Date: {{ Carbon::now()->format('d-m-Y') }}</small>
            </h4>
         </div>
         <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
         <div class="col-sm-4 invoice-col">
            De
            <address>
               <strong>Hotel, Inc.</strong><br>
               795 Folsom Ave, Suite 600<br>
               San Francisco, CA 94107<br>
               Phone: (804) 123-5432<br>
               Email: info@almasaeedstudio.com
            </address>
         </div>
         <!-- /.col -->
         <div class="col-sm-4 invoice-col">
            Au client
            <address>
               <strong>Client X</strong><br>
               <p>à la table {{ $ventes->first()->tableLinked->numero }}</p>
            </address>
         </div>
         <!-- /.col -->
         <div class="col-sm-4 invoice-col">
            <b>{{ $ventes->first()->code }}</b><br>
            <br>
            {{-- <b>Order ID:</b> 4F3S8J<br> --}}
            <b>Payment Due: </b>{{ $ventes->first()->created_at->format('d-m-Y') }}<br>
            {{-- <b>Account:</b> 968-34567 --}}
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
         <div class="col-12 table-responsive">
            @php
            $total = 0;
            @endphp
            <h3>Restauration</h3>
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th>Qte</th>
                     <th>Produit</th>
                     <th>Réference #</th>
                     <th>Prix unitaire</th>
                     <th>Subtotal</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($ventes as $vente)
                     @php
                     $total += $vente->prix*$vente->quantite
                     @endphp
                     <tr>
                        <td>{{ $vente->quantite }}</td>
                        <td>{{ $vente->produitLinked->libelle }}</td>
                        <td>{{ $vente->produitLinked->reference }}</td>
                        <td>{{ $vente->prix }}</td>
                        <td>{{ $vente->quantite * $vente->prix }}</td>
                     </tr>
                  @endforeach
               </tbody>
               <tfoot>
                  <tr>
                     <td colspan="4"><strong>Net à payer</strong></td>
                     <td>{{ $total }}</td>
                  </tr>
               </tfoot>
            </table>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
         <!-- accepted payments column -->
         <div class="col-6">
            <p class="lead">Méthodes de Payements:</p>
            Espece/Cheque
            {{-- <img src="../../dist/img/credit/visa.png" alt="Visa">
            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
            <img src="../../dist/img/credit/american-express.png" alt="American Express">
            <img src="../../dist/img/credit/paypal2.png" alt="Paypal"> --}}

            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
               Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
               plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
            <h3><span class="badge badge-pill badge-success">PAYER</span></h3>
            </p>
         </div>
         <!-- /.col -->
         <div class="col-6">
            {{-- <p class="lead">Amount Due 2/22/2014</p> --}}
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
         <div class="col-12">
            <a href="{{ route('service_vente_print', $ventes->first()->code) }}" target="_blank" class="btn btn-default"><i
                  class="fas fa-print"></i> Print</a>
            <payer-table-vente :table="{{ $ventes->first()->tableLinked->id }}" :code="'{{ $ventes->first()->code }}'">
            </payer-table-vente>
         </div>
      </div>
   </div>
@endsection
@section('script')
   <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
@endsection
