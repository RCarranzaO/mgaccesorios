<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;

class EmailController extends Controller
{
	/**
	 * La función envio manda el enlace para reestablecer la contraseña junto con el mensaje previamente definido al correo del usuario que realizará el cambio de contraseña.
	 * @param El parámetro requerido es el contenido de password.blade.php donde está el cuerpo del correo con el enlace para reestablecer la contraseña. 
	 * @return Devuelve la vista del correo que se enviará para el reestablecimiento de la contraseña.
	 */
    public function envio(Request $request)
    {
      Mail::send('email/password');
      return view ('Email/password');
    }
}
