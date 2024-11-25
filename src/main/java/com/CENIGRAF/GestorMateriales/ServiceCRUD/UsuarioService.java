package com.CENIGRAF.GestorMateriales.ServiceCRUD;


import com.CENIGRAF.GestorMateriales.ModelBD.UsuarioModel;
import com.CENIGRAF.GestorMateriales.Repository.UsuarioRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class UsuarioService {
    @Autowired
    private UsuarioRepository usuarioRepository;

    public List<UsuarioModel> getAll(){
        return usuarioRepository.getAll();
    }

    public Optional<UsuarioModel> getUsuarioModel(int id){
        return usuarioRepository.getUsuarioModel(id);
    }

    public UsuarioModel save(UsuarioModel usuarioModel){
        if (usuarioModel.getIdUsuario()==null){
            return usuarioRepository.save(usuarioModel);
        }else {
            Optional<UsuarioModel> usuaux=usuarioRepository.getUsuarioModel(usuarioModel.getIdUsuario());
            if (usuaux.isEmpty()){
                return usuarioRepository.save(usuarioModel);
            }else {
                return usuarioModel;
            }
        }
    }

    public UsuarioModel update(UsuarioModel usuarioModel){
        if (usuarioModel.getIdUsuario() != null){
            Optional<UsuarioModel> Us=usuarioRepository.getUsuarioModel(usuarioModel.getIdUsuario());
            if (!Us.isEmpty()){
                if (usuarioModel.getIdUsuario()!= null){
                    Us.get().setIdUsuario(usuarioModel.getIdUsuario());
                }
                if (usuarioModel.getContrasena()!= null){
                    Us.get().setContrasena(usuarioModel.getContrasena());
                }
                if (usuarioModel.getNombre()!= null){
                    Us.get().setNombre(usuarioModel.getNombre());
                }
                usuarioRepository.save(Us.get());
                return Us.get();
            }else {
                return usuarioModel;
            }
        }else {
            return usuarioModel;
        }
    }

    public boolean deleteUsuarioModel(int id){
        Boolean dUs =getUsuarioModel(id).map(usuarioModel -> {
            usuarioRepository.delete(usuarioModel);
            return true;
        }).orElse(false);
        return dUs;
    }

}
