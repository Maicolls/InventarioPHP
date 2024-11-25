package com.CENIGRAF.GestorMateriales.ControllerWeb;

import com.CENIGRAF.GestorMateriales.ModelBD.ProgramaModel;
import com.CENIGRAF.GestorMateriales.ServiceCRUD.ProgramaService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("api/ProgramaModel")
@CrossOrigin(origins = "*", methods = {RequestMethod.GET,RequestMethod.POST,RequestMethod.PUT,RequestMethod.DELETE})
public class ProgramaController {

    @Autowired
    private ProgramaService programaService;

    @GetMapping("/all")
    public List<ProgramaModel> getProgramaModels(){
        return programaService.getAll();
    }

    @GetMapping("/{id}")
    public Optional<ProgramaModel>getProgramaModel(@PathVariable("id")int id){
        return programaService.getProgramaModel(id);
    }

    @PostMapping("/save")
    @ResponseStatus(HttpStatus.CREATED)
    public ProgramaModel save(@RequestBody ProgramaModel programaModel){
        return programaService.save(programaModel);
    }

    @PutMapping("/update")
    @ResponseStatus(HttpStatus.CREATED)
    public ProgramaModel update(@RequestBody ProgramaModel programaModel){
        return programaService.update(programaModel);
    }

    @DeleteMapping("/{id}")
    @ResponseStatus(HttpStatus.NO_CONTENT)
    public boolean delete(@PathVariable("id")int id){
        return programaService.deleteProgramaModel(id);
    }
}
