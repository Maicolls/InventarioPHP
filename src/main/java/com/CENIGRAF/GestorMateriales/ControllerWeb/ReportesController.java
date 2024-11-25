package com.CENIGRAF.GestorMateriales.ControllerWeb;

import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.ReportesRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
@RequestMapping(path = "/ventas")
public class ReportesController {
    @Autowired
    ReportesRepository reportesRepository;

    //lista las ventas realizadas http://localhost:8080/ventas/
    @GetMapping(value = "/")
    public String mostrarVentas(Model model) {
        model.addAttribute("ventas", reportesRepository.findAll());
        return "ventas/ver_ventas";
    }

}
