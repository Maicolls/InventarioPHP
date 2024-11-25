package com.CENIGRAF.GestorMateriales.ControllerWeb;

import com.CENIGRAF.GestorMateriales.ModelBD.AmbienteModel;
import com.CENIGRAF.GestorMateriales.ServiceCRUD.AmbienteService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("api/AmbienteModel")
@CrossOrigin(origins = "*" , methods = {RequestMethod.GET,RequestMethod.POST,RequestMethod.PUT,RequestMethod.DELETE})

public class AmbienteController {

    @Autowired
    private AmbienteService ambienteService;

    @GetMapping("/all")
    public List<AmbienteModel> getAmbienteModels(){
        return ambienteService.getAll();
    }

    @GetMapping("/{id}")
    public Optional<AmbienteModel> getAmbienteModel(@PathVariable("id")int id){
        return ambienteService.getAmbienteModel(id);
    }

    @PostMapping("/save")
    @ResponseStatus(HttpStatus.CREATED)
    public AmbienteModel save(@RequestBody AmbienteModel ambienteModel){
        return ambienteService.save(ambienteModel);
    }

    @PutMapping("/update")
    @ResponseStatus(HttpStatus.CREATED)
    public AmbienteModel update(@RequestBody AmbienteModel ambienteModel){
        return ambienteService.update(ambienteModel);
    }

    @DeleteMapping("/{id}")
    @ResponseStatus(HttpStatus.NO_CONTENT)
    public boolean delete(@PathVariable("id")int id){
        return ambienteService.deleteAmbienteModel(id);
    }


}
