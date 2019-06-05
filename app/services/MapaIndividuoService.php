<?php

class MapaIndividuoService extends BaseService {

	protected $mapa;

  public function __construct(MapaIndividuo $mapa) {

    $this->mapa = $mapa;
  }

	/**
	 * Salvar novo indivíduo
	 * Retorna para mapaController
	 * @return Response
	 */
  public function store($input) {
  }

	/**
	 * Atualizar novo indivíduo
	 * Retorna para mapaController
	 * @return Response
	 */
  public function update($input, $id) {
  }

	/**
	 * Deletar novo indivíduo (soft delete)
	 * Retorna para mapaController
	 * @return Response
	 */
  public function destroy($id) {

  }

  public function restore($id) {

  }

}
