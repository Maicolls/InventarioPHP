package com.CENIGRAF.GestorMateriales.ControllerWeb;

import com.CENIGRAF.GestorMateriales.ModelBD.FichaModel;
import com.CENIGRAF.GestorMateriales.ServiceCRUD.FichaService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("api/FichaModel")
@CrossOrigin(origins = "*",methods = {RequestMethod.GET,RequestMethod.POST,RequestMethod.PUT,RequestMethod.DELETE})
public class FichaController {

    @Autowired
    private FichaService fichaService;

    @GetMapping("/all")
    public List<FichaModel>getFichaModels(){
        return fichaService.getAll();
    }

    @GetMapping("/{id}")
    public Optional<FichaModel>getFichaModel(@PathVariable("id")int id){
        return fichaService.getFichaModel(id);
    }

    @PostMapping("/save")
    @ResponseStatus(HttpStatus.CREATED)
    public FichaModel save(@RequestBody FichaModel fichaModel){
        return fichaService.save(fichaModel);
    }

    @PutMapping("/update")
    @ResponseStatus(HttpStatus.CREATED)
    public FichaModel update(@RequestBody FichaModel fichaModel){
        return fichaService.update(fichaModel);
    }

    @DeleteMapping("/{id}")
    @ResponseStatus(HttpStatus.NO_CONTENT)
    public boolean delete(@PathVariable("id")int id){
        return fichaService.deleteFichaModel(id);
    }



}
