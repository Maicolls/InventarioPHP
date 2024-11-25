package com.CENIGRAF.GestorMateriales.ControllerWeb;

import com.CENIGRAF.GestorMateriales.ModelBD.ElementoConsumible;
import com.CENIGRAF.GestorMateriales.ModelBD.ElementoParaSolicitar;
import com.CENIGRAF.GestorMateriales.ModelBD.ElementoSolicitado;
import com.CENIGRAF.GestorMateriales.ModelBD.Reporte;
import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.ElementosSolicitadosRepository;
import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.ElementosconsumiblesRepository;
import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.ReportesRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import java.util.ArrayList;

@Controller
@RequestMapping(path = "/vender")
public class SolicitarController {
    @Autowired
    private ElementosconsumiblesRepository elementosconsumiblesRepository;
    @Autowired
    private ReportesRepository reportesRepository;
    @Autowired
    private ElementosSolicitadosRepository elementosSolicitadosRepository;

    @PostMapping(value = "/quitar/{indice}")
    public String quitarDelCarrito(@PathVariable int indice, HttpServletRequest request) {
        ArrayList<ElementoParaSolicitar> carrito = this.obtenerCarrito(request);
        if (carrito != null && carrito.size() > 0 && carrito.get(indice) != null) {
            carrito.remove(indice);
            this.guardarCarrito(carrito, request);
        }
        return "redirect:/vender/";
    }

    private void limpiarCarrito(HttpServletRequest request) {
        this.guardarCarrito(new ArrayList<>(), request);
    }

    @GetMapping(value = "/limpiar")
    public String cancelarVenta(HttpServletRequest request, RedirectAttributes redirectAttrs) {
        this.limpiarCarrito(request);
        redirectAttrs
                .addFlashAttribute("mensaje", "Venta cancelada")
                .addFlashAttribute("clase", "info");
        return "redirect:/vender/";
    }

    @PostMapping(value = "/terminar")
    public String terminarVenta(HttpServletRequest request, RedirectAttributes redirectAttrs) {
        ArrayList<ElementoParaSolicitar> carrito = this.obtenerCarrito(request);
        // Si no hay carrito o está vacío, regresamos inmediatamente
        if (carrito == null || carrito.size() <= 0) {
            return "redirect:/vender/";
        }
        Reporte v = reportesRepository.save(new Reporte());
        // Recorrer el carrito
        for (ElementoParaSolicitar productoParaVender : carrito) {
            // Obtener el producto fresco desde la base de datos
            ElementoConsumible p = elementosconsumiblesRepository.findById(productoParaVender.getId()).orElse(null);
            if (p == null) continue; // Si es nulo o no existe, ignoramos el siguiente código con continue
            // Le restamos existencia
            p.restarExistenciaAlmacen(productoParaVender.getCantidad());
            // Lo guardamos con la existencia ya restada
            elementosconsumiblesRepository.save(p);
            // Creamos un nuevo producto que será el que se guarda junto con la venta
            ElementoSolicitado productoVendido = new ElementoSolicitado(productoParaVender.getCantidad(), productoParaVender.getContador(), productoParaVender.getDescripcionBien(), productoParaVender.getCodigoSena(),productoParaVender.getUnidadMedida(),productoParaVender.getObservacion(), v);
            // Y lo guardamos
            elementosSolicitadosRepository.save(productoVendido);
        }

        // Al final limpiamos el carrito
        this.limpiarCarrito(request);
        // e indicamos una venta exitosa
        redirectAttrs
                .addFlashAttribute("mensaje", "Venta realizada correctamente")
                .addFlashAttribute("clase", "success");
        return "redirect:/vender/";
    }

    //http://localhost:8080/vender/----elementos
    @GetMapping(value = "/")
    public String interfazVender(Model model, HttpServletRequest request) {
        model.addAttribute("producto", new ElementoConsumible());
        //suma de elementos de toda la solicitud
        float total = 0;
        ArrayList<ElementoParaSolicitar> carrito = this.obtenerCarrito(request);
        for (ElementoParaSolicitar p: carrito) total += p.getTotal();
        model.addAttribute("total", total);
        return "vender/vender";
    }

    private ArrayList<ElementoParaSolicitar> obtenerCarrito(HttpServletRequest request) {
        ArrayList<ElementoParaSolicitar> carrito = (ArrayList<ElementoParaSolicitar>) request.getSession().getAttribute("carrito");
        if (carrito == null) {
            carrito = new ArrayList<>();
        }
        return carrito;
    }

    private void guardarCarrito(ArrayList<ElementoParaSolicitar> carrito, HttpServletRequest request) {
        request.getSession().setAttribute("carrito", carrito);
    }

    @PostMapping(value = "/agregar")
    public String agregarAlCarrito(@ModelAttribute ElementoConsumible producto, HttpServletRequest request, RedirectAttributes redirectAttrs) {
        ArrayList<ElementoParaSolicitar> carrito = this.obtenerCarrito(request);
        ElementoConsumible productoBuscadoPorCodigo = elementosconsumiblesRepository.findFirstByCodigoSena(producto.getCodigoSena());
        if (productoBuscadoPorCodigo == null) {
            redirectAttrs
                    .addFlashAttribute("mensaje", "El producto con el código " + producto.getCodigoSena() + " no existe")
                    .addFlashAttribute("clase", "warning");
            return "redirect:/vender/";
        }
        if (productoBuscadoPorCodigo.sinExistenciaAlmacen()) {
            redirectAttrs
                    .addFlashAttribute("mensaje", "El producto está agotado")
                    .addFlashAttribute("clase", "warning");
            return "redirect:/vender/";
        }
        boolean encontrado = false;
        for (ElementoParaSolicitar productoParaVenderActual : carrito) {
            if (productoParaVenderActual.getCodigoSena().equals(productoBuscadoPorCodigo.getCodigoSena())) {
                productoParaVenderActual.aumentarCantidad();
                encontrado = true;
                break;
            }
        }
        if (!encontrado) {
            carrito.add(new ElementoParaSolicitar(productoBuscadoPorCodigo.getDescripcionBien(), productoBuscadoPorCodigo.getCodigoSena(),productoBuscadoPorCodigo.getUnidadMedida(), productoBuscadoPorCodigo.getObservacion(), productoBuscadoPorCodigo.getContador(), productoBuscadoPorCodigo.getExistenciaAlmacen(), productoBuscadoPorCodigo.getId(), 1f));
        }
        this.guardarCarrito(carrito, request);
        return "redirect:/vender/";
    }
}
