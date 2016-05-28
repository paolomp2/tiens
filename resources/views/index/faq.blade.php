<!DOCTYPE html>
<html lang="es">
   @include('layouts.head')
   <body>
      <div class="container">
         @include('layouts.container')
      </div>
      <section class="main-content">
         <div class="container">
            <div class="wrapper-content bg-transparent no-space">
               <div class="faq">
                  <?php $route_bg_lion="background-image:url('index/images/faq.jpg')";?>
                  <div class="cover-faq" style={!!$route_bg_lion!!}></div>
                  <div class="wrap-faq">
                     <div class="cont-faq">
                        <h2>Servicio al Cliente</h2>
                        <p>Ponemos a tu disposici&oacute;n las preguntas m&aacute;s frecuentes en el desarrollo de tu negocio:</p>
                     </div>
                     <div class="faqs">
                        <h3>PREGUNTAS FRECUENTES</h3>
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                           <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="headingOne">
                                 <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                      Actualiza tus datos!
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                 <div class="panel-body">
                                    <p>
                                       Para hacerlo, deber&aacute;s presentar lo siguiente:
                                    </p>
                                    <ul>
                                       <li>Formato debidamente lleno y firmado. <a href="index/faq/actualizacion-de-datos.pdf" download="Actualizaci&oacute;n de Datos">click aqui!</a></li>
                                       <li>Adjuntar copia de Documento de Identidad vigente.</li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="headingTwo">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                      Como cobrar comisiones (retribuciones)?
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                 <div class="panel-body">
                                    <ul>
                                      <li>
                                        Descarga la siguiente gu&iacute;a paso a paso:
                              				</li>
                              				<li>
                              					<a href="#" download="">Guia cobro comisiones.pdf</a>
                                      </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="headingThree">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                      C&oacute;mo comprar desde la Tienda Virtual?
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                 <div class="panel-body">
                                    <ul>
                                      <li>Haz click para ver el <a href="https://www.youtube.com/watch?v=7HSmTgQ4l84" target="_blank">video tutorial!</a>.</li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="headingFour">
                                 <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                      C&oacute;mo afiliar desde la Tienda Virtual?
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                 <div class="panel-body">
                                    <ul>
                                      <li>
                                        Para afiliarte deber&aacute;s ingresar a la p&aacute;gina web y hacer clic en &quot;Quiero afiliarme&quot;. Completa el formulario, elige los productos que deseas comprar y haz clic en Confirmar compra. Para mayor informaci&oacute;n, haz clic en el siguiente <a href="http://pe.tiens.com/content/14-como-comprar-desde-la-tienda-virtual" target="_blank">video tutorial</a>.
                                      </li>
                                      <li>
                                        *El kit de negocio se agrega autom&aacute;ticamente y es obligatorio.
                                      </li>
                                      <li>
                                        **Afiliaci&oacute;n en l&iacute;nea disponible en algunos pa&iacute;ses.
                                      </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="headingFive">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                      Como hacer un cambio de sucursal (Nacional)
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                 <div class="panel-body">
                                    <p>
                                      Para hacerlo, deber&aacute;s presentar lo siguiente:
                                    </p>
                                    <ul>
                                      <li>Formato debidamente lleno y firmado.</li>
                                      <li>Adjuntar copia de Documento de Identidad vigente. </li>
                                      <li>Deber&aacute;s descargar y completar el siguiente formulario y presentarlos en:</li>
					                             <li><a download="Cambio de Sucursal (Zona Nacional)" href="index/faq/cambio-de-sucursal-zona-nacional.pdf">Cambio de Sucursal (Nacional).pdf</a></li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="headingSix">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    C&oacute;mo traspasar un c&oacute;digo (por fallecimiento)
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                 <div class="panel-body">
                                    <p>
                                      Para hacerlo, deber&aacute;s presentar lo siguiente:
                                    </p>
                                    <ul>
                                      <li>
                                        Requisito indispensable ser familiar directo del fallecido.
                                      </li>
                                      <li>
                                        Formato correctamente llenado con las firmas correspondientes.
                                      </li>
                                      <li>
                                        El formato original y la copia Notarial del Certificado de Defunci&oacute;n.
                                      </li>
                                      <li>
                                        El original y copia legalizada del Testamento (de ser el caso).
                                      </li>
                                      <li>
                                        Copia de DNI del solicitante y del patrocinador.
                                      </li>
                                      <li>
                                        Copias de boletas o facturas de compras de productos ( las compras deber&aacute;n ser realizadas dentro del periodo).
                                      </li>
                                      <li>
                                        La primera p&aacute;gina del reporte de Red reciente.
                                      </li>
                                      <li>
                                        Documento que acredito el parentesco ( hijos, partida de nacimiento, esposo certificado de matrimonio).
                                      </li>
                                      <li>
                                        El distribuidor heredero deber&aacute; comprar productos por un m&iacute;nimo de 300 PVs.
                                      </li>
                                      <li>
                                        Para hacer una Cesi&oacute;n de c&oacute;digo, completa este formulario:
                                      </li>
                                      <li>
                                        <a href="index/faq/cesion-de-codigo-por-fallecimiento.pdf" download="Cesion de C&oacute;digo por Fallecimiento">Cesi&oacute;n de c&oacute;digo por fallecimiento.pdf</a>
                                      </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="headingSeven">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                      Anulaci&oacute;n de c&oacute;digo
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                                 <div class="panel-body">
                                  <p>
                                    Si eres 1, 2, 3 o 4 estrellas, <a href="index/faq/formato-de-anulacion-de-codigo-1-2-3-y-4-estrellas.pdf" download="Formato de anulaci&oacute;n de c&oacute;digo 1-2-3 y 4 estrellas">descarga esta ficha</a>:
                                  </p>
                                  <ul>
                                    <li>Formato correctamente llenado con la firma del solicitante</li>
                                    <li>Copia del DNI vigente del distribuidor solicitante.</li>
                                  </ul>
                                  <p>
                                    <strong>Observaciones:</strong>&nbsp;El Distribuidor que desea renunciar a su c&oacute;digo debe tener por lo menos 6 meses de afiliado (seg&uacute;n Manual de Negocios). Si el Distribuidor renunciante desea nuevamente inscribirse deber&aacute;n transcurrir 6 meses para hacerlo.
                                  </p>
                                  <p>
                                    Si eres 5 estrellas, <a href="index/faq/formato-de-anulacion-de-codigo-estatus-5-estrellas-a-superior.pdf" download="Formato de anulaci&oacute;n de c&oacute;digo estatus 5 estrellas a superior">descarga esta ficha</a>:
                                  </p>
                                  <ul>
                                    <li>Formato correctamente llenado con la firma del solicitante y la firma del patrocinador.</li>
                                    <li>Copia del DNI vigente del distribuidor solicitante y del patrocinador.</li>
                                  </ul>
                                  <p>
                                    <strong>Observaciones:</strong>&nbsp;El Distribuidor que desea renunciar a su c&oacute;digo debe tener por lo menos 6 meses de afiliado (seg&uacute;n Manual de Negocios). Si el Distribuidor renunciante desea nuevamente inscribirse deber&aacute;n transcurrir 6 meses para hacerlo.
                                  </p>
                                 </div>
                              </div>
                           </div>
                          <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="headingEight">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                      Deseo hacer un reclamo:
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight">
                                 <div class="panel-body">
                                  <ul>
                                    <li>Formato correctamente llenado con la firma correspondiente.</li>
                                    <li>Adjuntar documentos sustentatorios de reclamo.</li>
                                    <li>Completa este formulario:</li>
					                         <li><a href="index/faq/formato-de-reclamo.pdf" download="Formato de Reclamo">Formato de reclamo.pdf</a></li>
                                  </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="comunicate">
                     <div class="row">
                        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10">
                           <div class="bg-comunicate">
                              <div class="row">
                                 <div class="col-xs-12 col-sm-4">
                                    <?php $route_bg_comunication="background-image:url('index/images/bg-comunicate.jpg')";?>
                                    <div class="cover-comunicate" style={!!$route_bg_comunication!!}></div>
                                 </div>
                                <div class="col-xs-12 col-sm-8">
                                  <div class="wrap-comunicate">
                                    <h5>Estamos para atenderte</h5>
                                    <h3>Comun&iacute;cate con nosotros</h3>
                                    <p>
                                      <a target="_blank" href="http://pe.tiens.com/index.php?controller=contact">
                                        Env&iacute;anos una consulta o comentario aqu&iacute;:
                                        <img src="index/images/email-icon.png" style="width: 33px; margin-left: 12px;" /> 
                                      </a>
                                    </p>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-6 col-lg-4">Per&uacute;: <a href="tel:6146969">(1) 614-6969</a></div>
                                      <div class="col-xs-12 col-sm-6 col-lg-4">Ecuador: <a href="tel:2380528">(4) 238-0528</a></div>
                                      <div class="col-xs-12 col-sm-6 col-lg-4">Colombia: <a href="tel:7440880">(1) 744-0880</a></div>
                                      <div class="col-xs-12 col-sm-6 col-lg-4">Bolivia: <a href="tel:2971461">(1) 297-1461</a></div>
                                      <div class="col-xs-12 col-sm-6 col-lg-4">M&eacute;xico: <a href="tel:52810453">(1) 5-281-0453</a></div>
                                      <div class="col-xs-12 col-sm-6 col-lg-4">Chile: <a href="tel:">----</a></div>
                                      <div class="col-xs-12 col-sm-6">Venezuela: <a href="tel:----2127626250">(1) 212-762-6250</a></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <div class="container">
         @include('layouts.footer')
      </div>
      @include('layouts.scripts')
   </body>
</html>
