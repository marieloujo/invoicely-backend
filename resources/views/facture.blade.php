
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Laralink">
  <!-- Site Title -->
  <title>Invoice</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style2" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_content">
            <div class="tm_invoice_head tm_mb30">
              <div class="tm_invoice_left">
                <div class="tm_logo"><img src="{{ asset('img/logo.svg') }}" alt="Logo"></div>
              </div>
              <div class="tm_invoice_right tm_text_right">
                <b class="tm_f30 tm_medium tm_primary_color">Facture</b>
                <p class="tm_m0">Facture N° - {{ $facture->reference }}</p>
              </div>
            </div>
            <div class="tm_invoice_info tm_mb25">
              <div class="tm_invoice_info_left">
                <p class="tm_mb17">
                  <b class="tm_f18 tm_primary_color">{{ $facture->user->name }}</b> <br>
                  84 Spilman Street, London <br>United Kingdom. <br>
                  {{ $facture->user->email }} <br>
                </p>
              </div>
              <div class="tm_invoice_info_right">
                <div class="tm_text_right">
                    <img src="{{ asset('img/qrcode.png') }}" alt="qrcode" width="100" height="100">
                </div>
              </div>
            </div>
            <div class="tm_grid_row tm_col_2 tm_invoice_info_in tm_round_border tm_mb30">
              <div class="tm_border_right tm_border_none_sm">
                <b class="tm_primary_color">Client Info</b>
                <p class="tm_m0">
                    Name: {{ $facture->client->full_name }} <br>
                    Email: {{ $facture->client->email }} <br>
                    Phone: {{ $facture->client->phone_number }} <br>
                    Addrese: {{ $facture->client->adresse }}
                </p>
              </div>
              <div>
                <div class="row tm_m0">
                    <span class="tm_text_left">Code MECeF / DGI:</span>
                    <span class="tm_text_right">-----</span>
                </div>
                <div class="row tm_m0">
                    <span class="tm_text_left">MECeF NIM:</span>
                    <span class="tm_text_right">-----</span>
                </div>
                <div class="row tm_m0">
                    <span class="tm_text_left">MECeF Compteurs:</span>
                    <span class="tm_text_right">0 / 0    FV</span>
                </div>
                <div class="row tm_m0">
                    <span class="tm_text_left">MECeF Heure:</span>
                    <span class="tm_text_right">__/__/____ 00:00:00</span>
                </div>
              </div>
            </div>
            <div class="tm_table tm_style1">
              <div class="tm_round_border">
                <div class="tm_table_responsive">
                  <table>
                    <thead>
                      <tr>
                        <th class="tm_width_1 tm_semi_bold tm_primary_color">N°</th>
                        <th class="tm_width_4 tm_semi_bold tm_primary_color">Service</th>
                        <th class="tm_width_1 tm_semi_bold tm_primary_color">Qté</th>
                        <th class="tm_width_3 tm_semi_bold tm_primary_color">P.U HT</th>
                        <th class="tm_width_3 tm_semi_bold tm_primary_color tm_text_right">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($facture->items as $key => $item)
                            <tr>
                                <td class="tm_width_1">{{ $key + 1 }}</td>
                                <td class="tm_width_4">{{ $item->price->priceable->designation }}</td>
                                <td class="tm_width_1 tm_text_right">{{ $item->quantity }}</td>
                                <td class="tm_width_3">{{ format_amount($item->price->unit_price_excl) }} <small>XOF</small></td>
                                <td class="tm_width_3 tm_text_right">{{ format_amount($item->total_amount_excl) }} <small>XOF</small></td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tm_invoice_footer tm_mb15">
                <div class="tm_left_footer">
                </div>
                <div class="tm_right_footer">
                  <table class="tm_mb15">
                    <tbody>
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Sous Total</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">
                            {{ format_amount($facture->total_amount_excl) }} <small>XOF</small>
                        </td>
                      </tr>
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Tax 18%</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">
                            +{{ format_amount($facture->total_amount_incl - $facture->total_amount_excl) }} <small>XOF</small>
                        </td>
                      </tr>
                      <tr>
                        <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_gray_bg tm_radius_6_0_0_6">Grand Total	</td>
                        <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_text_right tm_gray_bg tm_radius_0_6_6_0">
                            {{ format_amount($facture->total_amount_incl) }} <small>XOF</small>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tm_note tm_text_center tm_font_style_normal">
              <hr class="tm_mb15">
            </div><!-- .tm_note -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('js/html2canvas.min.js') }}"></script>
</body>