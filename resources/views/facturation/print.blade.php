@extends('layouts.default')
@section('content')
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
              <div class="col-12">
                  <h4>
                      <i class="fas fa-globe"></i> Hotel, Inc.
                      <small class="float-right">Date: {{Carbon::now()->format('d-m-Y')}}</small>
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
                      Email: info
                      @almasaeedstudio.com
                  </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                  Au client
                  <address>
                      @if ($facture->clientLinked)
                        <strong>{{$facture->clientLinked->nom.' '.$facture->clientLinked->prenom}}</strong><br>
                        {{-- 795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br> --}}
                        Phone: (225) {{$facture->clientLinked->contact}}<br>
                        {{$facture->clientLinked->pieceLinked->libelle}}:{{$facture->clientLinked->numero_piece}}
                        @else
                        <strong>Client X</strong><br>
                      @endif
                  </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                  <b>{{$facture->reference}}</b><br>
                  <br>
                  {{-- <b>Order ID:</b> 4F3S8J<br> --}}
                  <b>Payment Due:</b>{{$facture->created_at->format('d-m-Y')}}<br>
                  {{-- <b>Account:</b> 968-34567 --}}
              </div>
              <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
              <div class="col-12 table-responsive">
                @php
                  $total_restauration = 0 ;
                  if($facture->sejourLinked){
                     $produits = $facture->sejourLinked->produits ;
                     $attribution = $facture->sejourLinked->sejourLinked ;
                     $batiment = $facture->sejourLinked->batimentLinked ;
                     $temps = 'Jours' ;
                  }else{
                     $produits = $facture->passageLinked->produits ;
                     $attribution = $facture->passageLinked->passageLinked ;
                     $batiment = $facture->passageLinked->batimentLinked ;
                     $temps = 'Heures' ;
                  }
                @endphp
                 @if ($produits)
                   <h3>Restauration</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Qte</th>
                                <th>Produit</th>
                                <th>reference #</th>
                                <th>Prix unitaire</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produits as $produit)
                              @php
                               $total_restauration += $produit->pivot->quantite*$produit->pivot->prix
                              @endphp
                              <tr>
                                  <td>{{$produit->pivot->quantite}}</td>
                                  <td>{{$produit->libelle}}</td>
                                  <td>{{$produit->reference}}</td>
                                  <td>{{$produit->pivot->prix}}</td>
                                  <td>{{$produit->pivot->quantite*$produit->pivot->prix}}</td>
                              </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="4"><strong>Total restauration</strong></td>
                            <td>{{$total_restauration}}</td>
                          </tr>
                        </tfoot>
                    </table>
                 @endif
                 <h3>Service hotel</h3>
                 <table class="table table-striped">
                     <thead>
                         <tr>
                             <th>Chambre</th>
                             <th>Batiment</th>
                             <th>Délais</th>
                             <th>Prix unitaire</th>
                             <th>Subtotal</th>
                         </tr>
                     </thead>
                     <tbody>
                         @php
                           $cout_brut_chambre = $facture->prix_unitaire*$facture->quantite ;
                         @endphp
                         <tr>
                             <td>{{$attribution->chambreLinked->libelle}}:{{$attribution->chambreLinked->typeLinked->libelle}}</td>
                             <td>{{$batiment->libelle}}</td>
                             <td>{{$facture->quantite}} {{$temps}}</td>
                             <td>{{$facture->prix_unitaire}}</td>
                             <td>{{$cout_brut_chambre}}</td>
                         </tr>
                     </tbody>
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
                  </p>
              </div>
              <!-- /.col -->
              <div class="col-6">
                  {{-- <p class="lead">Amount Due 2/22/2014</p> --}}

                  <div class="table-responsive">
                      <table class="table">
                          <tr>
                              <th style="width:50%">Coût Chambre:</th>
                              <td>{{$cout_brut_chambre}}</td>
                          </tr>
                          <tr>
                              <th>Remise({{$facture->remise}} %)</th>
                              <td>-{{$cout_brut_chambre*$facture->remise/100}}</td>
                          </tr>
                          <tr>
                              <th>Coût Net</th>
                              <td>{{$cout_brut_chambre*(1-$facture->remise/100)}}</td>
                          </tr>
                          <tr>
                              <th>Avance:</th>
                              <td>-{{$cout_brut_chambre*$facture->avance/100}}</td>
                          </tr>
                          <tr>
                              <th>Net Chambre:</th>
                              <td>{{$cout_brut_chambre*(1-$facture->avance/100)-$cout_brut_chambre*$facture->remise/100}}</td>
                          </tr>
                          <tr>
                            <th>Restauration</th>
                            <td>{{$total_restauration}}</td>
                          </tr>
                          <tr>
                              <th>Total:</th>
                              <td>{{($cout_brut_chambre*(1-$facture->avance/100)-$cout_brut_chambre*$facture->remise/100)+$total_restauration}}</td>
                          </tr>
                      </table>
                  </div>
              </div>
              <!-- /.col -->
          </div>
          <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('script')
<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>
@endsection
