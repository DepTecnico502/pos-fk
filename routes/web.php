<?php

use App\Http\Controllers\AjustesDeInventarioController;
use App\Http\Controllers\AperturaCajaController;
use App\Http\Controllers\ArticulosController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CategoriaProductoController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DetalleAperturaCajaController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\mediosdepagoController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\RecepcionesController;
use App\Http\Controllers\ReporteVentasController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VentasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('auth');

//LOGIN
Route::get('/login', [SessionsController::class, 'create'])->middleware('guest')->name('login.index');
Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
Route::get('/logout', [SessionsController::class, 'destroy'])->middleware('auth')->name('login.destroy');

//USUARIOS
Route::get('configuracion/usuarios', [UsuariosController::class, 'index'])->middleware('auth.admin')->name('configuracion.usuarios.index');
Route::get('configuracion/usuarios/crear', [UsuariosController::class, 'create'])->middleware('auth.admin')->name('configuracion.usuarios.create');
Route::post('configuracion/usuarios', [UsuariosController::class, 'store'])->middleware('auth.admin')->name('configuracion.usuarios.store');
Route::get('configuracion/usuarios/{id}', [UsuariosController::class, 'show'])->middleware('auth.admin')->name('configuracion.usuarios.editar');
Route::put('configuracion/usuarios/{usuario}', [UsuariosController::class, 'update'])->middleware('auth.admin')->name('configuracion.usuarios.update');

//MEDIOS DE PAGO
Route::get('configuracion/medios-de-pago', [mediosdepagoController::class, 'index'])->middleware('auth.conta')->name('configuracion.mediosdepago.index');
Route::get('configuracion/medios-de-pago/crear', [mediosdepagoController::class, 'create'])->middleware('auth.conta')->name('configuracion.mediosdepago.create');
Route::post('configuracion/medios-de-pago', [mediosdepagoController::class, 'store'])->middleware('auth.conta')->name('configuracion.mediosdepago.store');
Route::get('configuracion/medios-de-pago/{id}', [mediosdepagoController::class, 'show'])->middleware('auth.conta')->name('configuracion.mediosdepago.editar');
Route::put('configuracion/medios-de-pago/{id}', [mediosdepagoController::class, 'update'])->middleware('auth.conta')->name('configuracion.mediosdepago.update');

//CLIENTES
Route::get('clientes', [ClientesController::class, 'index'])->middleware('auth.conta')->name('clientes.index');
Route::get('clientes/crear', [ClientesController::class, 'create'])->middleware('auth.conta')->name('clientes.create');
Route::get('clientes/{id}', [ClientesController::class, 'show'])->middleware('auth.conta')->name('clientes.editar');
Route::put('clientes/{cliente}', [ClientesController::class, 'update'])->middleware('auth.conta')->name('clientes.update');
Route::post('clientes', [ClientesController::class, 'store'])->middleware('auth.conta')->name('clientes.store');

//PROVEEDORES
Route::get('proveedores', [ProveedoresController::class, 'index'])->middleware('auth.conta')->name('proveedores.index');
Route::get('proveedores/crear', [ProveedoresController::class, 'create'])->middleware('auth.conta')->name('proveedores.create');
Route::get('proveedores/{id}', [ProveedoresController::class, 'show'])->middleware('auth.conta')->name('proveedores.editar');
Route::put('proveedores/{proveedor}', [ProveedoresController::class, 'update'])->middleware('auth.conta')->name('proveedores.update');
Route::post('proveedores', [ProveedoresController::class, 'store'])->middleware('auth.conta')->name('proveedores.store');

//ARTÍCULOS
Route::get('articulos', [ArticulosController::class, 'index'])->middleware('auth.admin')->name('articulos.index');
Route::get('articulos/crear', [ArticulosController::class, 'create'])->middleware('auth.admin')->name('articulos.create');
Route::get('articulos/{id}', [ArticulosController::class, 'show'])->middleware('auth.admin')->name('articulos.editar');
Route::get('articulos/{id}/historial', [ArticulosController::class, 'getHistorialArticulo'])->middleware('auth.admin')->name('articulos.historial');
Route::put('articulos/{articulo}', [ArticulosController::class, 'update'])->middleware('auth.admin')->name('articulos.update');
Route::post('articulos', [ArticulosController::class, 'store'])->middleware('auth.admin')->name('articulos.store');

//RECEPCIONES
Route::get('recepciones', [RecepcionesController::class, 'index'])->middleware('auth.conta')->name('recepciones.index');
Route::get('recepciones/agregar', [RecepcionesController::class, 'create'])->middleware('auth.conta')->name('recepciones.create');
Route::get('recepciones/{id}', [RecepcionesController::class, 'view'])->middleware('auth.conta')->name('recepciones.view');
Route::post('recepciones/agregar', [RecepcionesController::class, 'addArticulo'])->middleware('auth.conta')->name('recepciones.addarticulo');
Route::post('recepciones/finalizar', [RecepcionesController::class, 'store'])->middleware('auth.conta')->name('recepciones.store');
Route::delete('recepciones/eliminar/{id}', [RecepcionesController::class, 'destroy'])->middleware('auth.conta')->name('recepciones.destroy');

//VENTAS
Route::get('ventas', [VentasController::class, 'index'])->middleware('auth.vendedor')->name('ventas.index');
Route::get('ventas/agregar', [VentasController::class, 'create'])->middleware('auth.vendedor')->name('ventas.create');
Route::get('ventas/{id}', [VentasController::class, 'show'])->middleware('auth.vendedor')->name('ventas.show');
Route::post('ventas/agregar', [VentasController::class, 'addArticulo'])->middleware('auth.vendedor')->name('ventas.addarticulo');
Route::post('ventas/finalizar', [VentasController::class, 'store'])->middleware('auth.vendedor')->name('ventas.store');
Route::delete('ventas/eliminar/{id}', [VentasController::class, 'destroy'])->middleware('auth.vendedor')->name('ventas.destroy');

//AJUSTES DE INVENTARIO
Route::get('ajustes-de-inventario', [AjustesDeInventarioController::class, 'index'])->middleware('auth.conta')->name('ajustesdeinventario.index');
Route::get('ajustes-de-inventario/agregar', [AjustesDeInventarioController::class, 'create'])->middleware('auth.conta')->name('ajustesdeinventario.create');
Route::get('ajustes-de-inventario/{id}', [AjustesDeInventarioController::class, 'view'])->middleware('auth.conta')->name('ajustesdeinventario.view');
Route::post('ajustes-de-inventario/agregar', [AjustesDeInventarioController::class, 'addArticulo'])->middleware('auth.conta')->name('ajustesdeinventario.addarticulo');
Route::post('ajustes-de-inventario/finalizar', [AjustesDeInventarioController::class, 'store'])->middleware('auth.conta')->name('ajustesdeinventario.store');
Route::delete('ajustes-de-inventario/eliminar/{cod_interno}',[AjustesDeInventarioController::class, 'destroy'])->middleware('auth.conta')->name('ajustesdeinventario.destroy');

//CATEGORÍAS
Route::get('categorias', [CategoriaProductoController::class, 'index'])->middleware('auth.admin')->name('categoria.index');
Route::get('categorias/crear', [CategoriaProductoController::class, 'create'])->middleware('auth.admin')->name('categoria.create');
Route::post('categorias', [CategoriaProductoController::class, 'store'])->middleware('auth.admin')->name('categoria.store');
Route::get('categorias/{id}', [CategoriaProductoController::class, 'edit'])->middleware('auth.admin')->name('categoria.editar');
Route::put('categorias/{categoria}', [CategoriaProductoController::class, 'update'])->middleware('auth.admin')->name('categoria.update');

//APERTURA DE CAJA
Route::get('apertura', [AperturaCajaController::class, 'index'])->middleware('auth')->name('apertura.index');
Route::get('apertura/agregar', [AperturaCajaController::class, 'create'])->middleware('auth.conta')->name('apertura.create');
Route::get('apertura/{id}', [AperturaCajaController::class, 'show'])->middleware('auth.conta')->name('apertura.view');
Route::get('apertura/{id}/edit', [AperturaCajaController::class, 'edit'])->middleware('auth.conta')->name('apertura.edit');
Route::put('apertura/{apertura}', [AperturaCajaController::class, 'update'])->middleware('auth.conta')->name('apertura.update');
Route::post('apertura/finalizar', [AperturaCajaController::class, 'store'])->middleware('auth.conta')->name('apertura.store');

//MOVIMIENTOS DE CAJA
Route::get('movimientos', [DetalleAperturaCajaController::class, 'index'])->middleware('auth')->name('movimientos.index');
Route::get('movimientos/agregar', [DetalleAperturaCajaController::class, 'create'])->middleware('auth')->name('movimientos.create');
Route::post('movimientos/finalizar', [DetalleAperturaCajaController::class, 'store'])->middleware('auth')->name('movimientos.store');

//REPORTE DE VENTAS
Route::get('reportes/ventas', [ReporteVentasController::class, 'ventas'])->middleware('auth.admin')->name('reporte.ventas.index');
Route::get('reportes/saldos-pendientes', [ReporteVentasController::class, 'saldos_pendientes'])->middleware('auth.admin')->name('reporte.saldos-pendientes');
Route::get('reportes/saldos-resumen', [ReporteVentasController::class, 'saldos_resumen'])->middleware('auth.admin')->name('reporte.saldos-resumen');

//EXPORTACIONES
Route::get('/export', [ExportExcelController::class, 'export'])->middleware('auth.admin')->name('ventas.excel');
Route::get('/export/pagos', [ExportExcelController::class, 'pagosExport'])->middleware('auth.admin')->name('pagos.excel');
Route::get('/export/saldos-pendientes', [ExportExcelController::class, 'saldosExport'])->middleware('auth.admin')->name('saldos-pendientes.excel');
Route::get('/export/saldos-resumen', [ExportExcelController::class, 'saldosResumenExport'])->middleware('auth.admin')->name('saldos-resumen.excel');

//PAGOS
Route::get('/pagos', [PagosController::class, 'index'])->middleware('auth.admin')->name('pagos.index');
Route::get('/pagos/agregar', [PagosController::class, 'create'])->middleware('auth.admin')->name('pagos.create');
Route::post('/pagos/finalizar', [PagosController::class, 'store'])->middleware('auth.admin')->name('pagos.store');

// PDF
Route::get('/pdf/venta/{id}', [PdfController::class, 'venta'])->middleware('auth.vendedor')->name('pdf.venta');

// Ticket
Route::get('/ticket/venta/{id}', [TicketController::class, 'venta'])->middleware('auth.vendedor')->name('ticket.venta');

// Anulación de factura
Route::get('/venta/anular/factura/{venta}', [VentasController::class, 'anularFactura'])->middleware('auth.vendedor')->name('venta.anular');

// Cajas
Route::get('/cajas', [CajaController::class,'index'])->middleware('auth.conta')->name('cajas.index');
Route::get('/caja/{id}/editar', [CajaController::class,'edit'])->middleware('auth.conta')->name('caja.editar');
Route::put('/caja/{id}/actualizar', [CajaController::class, 'update'])->middleware('auth.conta')->name('caja.update');
Route::get('/caja/crear', [CajaController::class,'create'])->middleware('auth.conta')->name('caja.crear');
Route::post('/caja/crear', [CajaController::class,'store'])->middleware('auth.conta')->name('caja.store');

// Series
Route::get('/configuracion/series', [SerieController::class, 'index'])->middleware('auth.admin')->name('configuracion.series.index');
Route::get('/configuracion/series/{id}/editar', [SerieController::class, 'edit'])->middleware('auth.admin')->name('configuracion.series.edit');
Route::put('/configuracion/series/{serie}', [SerieController::class, 'update'])->middleware('auth.admin')->name('configuracion.series.update');
Route::get('/configuracion/series/crear', [SerieController::class, 'create'])->middleware('auth.admin')->name('configuracion.series.create');
Route::post('/configuracion/series/crear', [SerieController::class, 'store'])->middleware('auth.admin')->name('configuracion.series.store');

//ERROR 403
Route::get('/denied', function () {
    return view('errors.403');
});