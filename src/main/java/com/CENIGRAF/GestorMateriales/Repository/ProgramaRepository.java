package com.CENIGRAF.GestorMateriales.Repository;

import com.CENIGRAF.GestorMateriales.ModelBD.ProgramaModel;
import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.ProgramaCrudRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public class ProgramaRepository {

    @Autowired
    private ProgramaCrudRepository programaCrudRepository;

    public List<ProgramaModel>getAll(){
        return (List<ProgramaModel>) programaCrudRepository.findAll();
    }

    public Optional<ProgramaModel>getProgramaModel(int id){
        return programaCrudRepository.findById(id);
    }

    public ProgramaModel save(ProgramaModel programaModel){
        return programaCrudRepository.save(programaModel);
    }

    public void delete (ProgramaModel programaModel){
        programaCrudRepository.delete(programaModel);
    }

}
