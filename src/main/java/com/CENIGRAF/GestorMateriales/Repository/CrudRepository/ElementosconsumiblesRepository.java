package com.CENIGRAF.GestorMateriales.Repository.CrudRepository;

import com.CENIGRAF.GestorMateriales.ModelBD.ElementoConsumible;
import org.springframework.data.repository.CrudRepository;

public interface ElementosconsumiblesRepository extends CrudRepository<ElementoConsumible, Integer> {

    ElementoConsumible findFirstByCodigoSena(String codigoSena);
}
