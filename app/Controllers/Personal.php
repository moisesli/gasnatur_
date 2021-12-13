<?php

namespace App\Controllers;

use Config\Controller;
use App\Models\PersonalModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Personal extends Controller
{
	public $personal;

	public function __construct()
	{
		$this->personal = $this->loadModel('Personal');
	}

	public function create(Request $request, Response $response)
	{

		$statusOk = false;
		$messageError = "";

		try {

			$data = $request->toArray();
			$this->validaciones($request, $response);

			// if ($this->personal->findByComparatorRegister($data['nombres']) == 1) {
			// 	throw new \Exception("La zona ya existe, por favor ingresar una nueva zona");
			//   }

			// if (count($data) == 0) {
			// 	throw new \Exception("No existe parametros");
			// }

			// if ($data['nombres'] == "") {
			// 	throw new \Exception("Ingrese el nombre del personal");
			// }

			// if ($data['apellidos'] == "") {
			// 	throw new \Exception("Ingrese el apellido del personal");
			// }

			// $data['nombres'] = strtolower($data['nombres']);

			$result = $this->personal->create($data);

			[$statusOk, $messageError] = array_values((array)$result);
		} catch (\Exception $e) {
			$messageError = $e->getMessage();
		}

		return $this->resjson(["success" => $statusOk, "message" => $messageError], 201);
	}

	public function getAll(Response $response)
	{
		$results = $this->personal->getAll();
		return $this->resjson($results);
	}

	public function getById(Response $response, $id)
	{

		$result = $this->personal->findById($id);

		return $this->resjson($result);
	}

	public function update(Request $request, Response $response, $id)
	{
		$statusOk = false;
		$messageError = "";

		try {

			$data = $request->toArray();

			// if ($this->zone->findByComparatorRegister($data['nombre']) == 1) {
			// 	throw new \Exception("La zona ya existe, por favor ingresar una nueva zona");
			//   }


			if (count($data) == 0) {
				throw new \Exception("No existe parámetros");
			}

			// if ($id == "") {
			// 	throw new \Exception("No existe el id de la zona");
			// }
			// if ($data['nombre'] == "") {
			// 	throw new \Exception("Ingrese el nombre de la zona");
			// }
			// if ($data['estado'] == "") {
			// 	throw new \Exception("Seleccione el estado de la zona");
			// }

			$result = $this->personal->update($data, $id);

			[$statusOk, $messageError] = array_values((array)$result);
		} catch (\Exception $e) {
			$messageError = $e->getMessage();
		}

		return $this->resjson(["success" => $statusOk, "message" => $messageError], 200);
	}

	public function delete(Request $request, Response $response, $id)
	{
		$statusOk = false;
		$messageError = "";

		try {

			if ($id == "") {
				throw new \Exception("No existe el id del personal");
			}

			$result = $this->personal->delete($id);

			[$statusOk, $messageError] = array_values((array)$result);
		} catch (\Exception $e) {
			$messageError = $e->getMessage();
		}

		return $this->resjson(["success" => $statusOk, "message" => $messageError], 200);
	}

	private function validaciones(Request $request, Response $response)
	{

		$data = $request->toArray();

		if (count($data) == 0) {
			throw new \Exception("No existe parametros");
		}

		if ($data['nombres'] == "") {
			throw new \Exception("Ingrese el nombre del personal");
		}

		if ($data['apellidos'] == "") {
			throw new \Exception("Ingrese el apellido del personal");
		}

		if ($data['numero'] == "") {
			throw new \Exception("Ingrese numero");
		}

		if ($data['fecha_nacimiento'] == "") {
			throw new \Exception("Ingrese fecha de nacimiento");
		}

		// if (!(preg_match('/^\d{4}([\-/.])(0?[1-9]|1[1-2])\1(3[01]|[12][0-9]|0?[1-9])$/', $data['fecha_nacimiento']))) {
		// 	throw new \Exception("Ingrese el formato correcto aaaa/mm/dd");
		// }

		if ($data['sexo'] == "") {
			throw new \Exception("Seleccione su género");
		}

		if (!(preg_match('/^[a-zA-Z ]+$/', $data['nombres']))) {
			throw new \Exception("Se permiten solo letras");
		}

		if (!(preg_match('/^[a-zA-Z ]+$/', $data['apellidos']))) {
			throw new \Exception("Se permiten solo letras");
		}
	}

	public function paginator($id = "", $q = "")
	{
		return $this->personal->paginator($id, $q);
	}
}
