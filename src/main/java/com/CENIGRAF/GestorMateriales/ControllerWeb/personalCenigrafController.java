package com.CENIGRAF.GestorMateriales.ControllerWeb;

import com.CENIGRAF.GestorMateriales.ModelBD.personalCenigrafModel;
import com.CENIGRAF.GestorMateriales.ServiceCRUD.personalCenigrafService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/api/PersonalCenigrafModel")
@CrossOrigin(origins = "*" , methods = {RequestMethod.GET,RequestMethod.POST,RequestMethod.PUT,RequestMethod.DELETE})

public class personalCenigrafController {

    @Autowired
    private com.CENIGRAF.GestorMateriales.ServiceCRUD.personalCenigrafService personalCenigrafService;

    @GetMapping("/all")
    public List<personalCenigrafModel> getPersonalCenigrafModels(){
        return personalCenigrafService.getAll();
    }

    @GetMapping("/{id}")
    public Optional<personalCenigrafModel> getPersonalCenigrafModel(@PathVariable("id")int id){
        return personalCenigrafService.getPersonalCenigrafModel(id);
    }

    @PostMapping("/save")
    @ResponseStatus(HttpStatus.CREATED)
    public personalCenigrafModel save(@RequestBody personalCenigrafModel personalCenigrafModel){
        return personalCenigrafService.save(personalCenigrafModel);
    }

    @PutMapping("/update")
    @ResponseStatus(HttpStatus.CREATED)
    public personalCenigrafModel update(@RequestBody personalCenigrafModel personalCenigrafModel){
        return personalCenigrafService.update(personalCenigrafModel);
    }

    @DeleteMapping("/{id}")
    @ResponseStatus(HttpStatus.NO_CONTENT)
    public boolean delete(@PathVariable("id")int id){
        return personalCenigrafService.deletePersonalCenigrafModel(id);

    }

}
