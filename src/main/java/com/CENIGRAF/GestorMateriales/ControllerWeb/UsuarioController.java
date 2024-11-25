package com.CENIGRAF.GestorMateriales.ControllerWeb;


import com.CENIGRAF.GestorMateriales.ModelBD.UsuarioModel;
import com.CENIGRAF.GestorMateriales.ServiceCRUD.UsuarioService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/api/UserModel")
@CrossOrigin(origins = "*" , methods = {RequestMethod.GET,RequestMethod.POST,RequestMethod.PUT,RequestMethod.DELETE})

public class UsuarioController {
    @Autowired
    private UsuarioService usuarioService;

    @GetMapping("/all")
    public List<UsuarioModel> getUsuarioModels(){
        return usuarioService.getAll();
    }

    @GetMapping("/{id}")
    public Optional<UsuarioModel> getUsuarioModel(@PathVariable("id") int id){
        return usuarioService.getUsuarioModel(id);
    }

    @PostMapping("/save")
    @ResponseStatus(HttpStatus.CREATED)
    public UsuarioModel save(@RequestBody UsuarioModel usuarioModel){
        return usuarioService.save(usuarioModel);
    }

    @PutMapping("/update")
    @ResponseStatus(HttpStatus.CREATED)
    public UsuarioModel update(@RequestBody UsuarioModel usuarioModel){
        return usuarioService.update(usuarioModel);
    }

    @DeleteMapping("/{id}")
    @ResponseStatus(HttpStatus.NO_CONTENT)
    public boolean delete(@PathVariable("id")int id){
        return usuarioService.deleteUsuarioModel(id);
    }
}
