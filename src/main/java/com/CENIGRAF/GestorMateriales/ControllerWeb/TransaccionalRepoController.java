package com.CENIGRAF.GestorMateriales.ControllerWeb;

import com.CENIGRAF.GestorMateriales.ModelBD.TransaccionalRepoModel;
import com.CENIGRAF.GestorMateriales.ServiceCRUD.TransaccionalRepoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/api/ReporteMantenimiento")
@CrossOrigin(origins = "*",methods = {RequestMethod.GET,RequestMethod.POST,RequestMethod.PUT,RequestMethod.DELETE})
public class TransaccionalRepoController {

    @Autowired
    private TransaccionalRepoService transaccionalRepoService;

    @GetMapping("/all")
    public List<TransaccionalRepoModel> getTransaccionalRepoModels(){
        return transaccionalRepoService.getAll();
    }

    @GetMapping("/{id}")
    public Optional<TransaccionalRepoModel> getTransaccionalRepoModel(@PathVariable("id")int id){
        return transaccionalRepoService.getTransaccionalRepoModel(id);
    }

    @PostMapping("/save")
    @ResponseStatus(HttpStatus.CREATED)
    public TransaccionalRepoModel save(@RequestBody TransaccionalRepoModel transaccionalRepoModel){
        return transaccionalRepoService.save(transaccionalRepoModel);
    }

    @PutMapping("/update")
    @ResponseStatus(HttpStatus.CREATED)
    public TransaccionalRepoModel update(@RequestBody TransaccionalRepoModel transaccionalRepoModel){
        return transaccionalRepoService.update(transaccionalRepoModel);
    }

    @DeleteMapping("{id}")
    @ResponseStatus(HttpStatus.NO_CONTENT)
    public boolean delete(@PathVariable("id")int id){
        return transaccionalRepoService.deleteTransaccionalRepoModel(id);
    }

}
