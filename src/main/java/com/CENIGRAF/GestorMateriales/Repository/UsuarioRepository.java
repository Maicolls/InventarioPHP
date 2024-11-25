package com.CENIGRAF.GestorMateriales.Repository;

import com.CENIGRAF.GestorMateriales.ModelBD.UsuarioModel;
import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.UsuarioCrudRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public class UsuarioRepository {
    @Autowired
    private UsuarioCrudRepository usuarioCrudRepository;

    public List<UsuarioModel> getAll(){
        return (List<UsuarioModel>) usuarioCrudRepository.findAll();
    }

    public Optional<UsuarioModel> getUsuarioModel(int id){
        return usuarioCrudRepository.findById(id);
    }

    public UsuarioModel save(UsuarioModel usuarioModel){
        return usuarioCrudRepository.save(usuarioModel);
    }

    public void delete(UsuarioModel usuarioModel){
        usuarioCrudRepository.delete(usuarioModel);
    }

}
