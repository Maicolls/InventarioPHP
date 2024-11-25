package com.CENIGRAF.GestorMateriales.ControllerWeb;

import com.CENIGRAF.GestorMateriales.ModelBD.MaquinaModel;
import com.CENIGRAF.GestorMateriales.ServiceCRUD.MaquinaService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("api/MaquinaModel")
@CrossOrigin(origins = "*",methods = {RequestMethod.GET,RequestMethod.POST,RequestMethod.PUT,RequestMethod.DELETE})

public class MaquinaController {

    @Autowired
    private MaquinaService maquinaService;

    @GetMapping("/all")
    public List<MaquinaModel>getMaquinaModels(){
        return maquinaService.getAll();
    }

    @GetMapping("/{id}")
    public Optional<MaquinaModel>getMaquinaModel(@PathVariable("id")int id){
        return maquinaService.getMaquinaModel(id);
    }

    @PostMapping("/save")
    @ResponseStatus(HttpStatus.CREATED)
    public MaquinaModel save(@RequestBody MaquinaModel maquinaModel){
        return maquinaService.save(maquinaModel);
    }



    @PutMapping("/update")
    @ResponseStatus(HttpStatus.CREATED)
    public MaquinaModel update(@RequestBody MaquinaModel maquinaModel){
        return maquinaService.update(maquinaModel);
    }



    @DeleteMapping("/{id}")
    @ResponseStatus(HttpStatus.NO_CONTENT)
    public boolean delete(@PathVariable("id")int id){
        return maquinaService.deleteMaquinaModel(id);
    }
}
