package com.CENIGRAF.GestorMateriales.Repository;

import com.CENIGRAF.GestorMateriales.ModelBD.MaquinaModel;
import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.MaquinaCrudRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public class MaquinaRepository {

    @Autowired
    private MaquinaCrudRepository maquinaCrudRepository;

    public List<MaquinaModel> getAll(){
        return (List<MaquinaModel>) maquinaCrudRepository.findAll();
    }

    public Optional<MaquinaModel> getMaquinaModel(int id){
        return maquinaCrudRepository.findById(id);
    }

    public MaquinaModel save(MaquinaModel maquinaModel){
        return maquinaCrudRepository.save(maquinaModel);
    }

    public void delete(MaquinaModel maquinaModel){
        maquinaCrudRepository.delete(maquinaModel);
    }

}
