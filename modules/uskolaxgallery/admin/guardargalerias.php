<?php



Function GuardarGalerias($ID, $Carpeta, $Imagen, $Descripcion, $Aleatorio, $Bloque, $MCatalogos, $AnchoBloque, $AltoBloque, $AnchoImagenes, $AltoImagenes, $FotosAncho, $FotosAlto, $EnviarFicheros, $EnviarComentarios, $EnviarVotaciones, $EnviarEnlaces, $NecesarioRegistrar, $InicioDescargas, $FinDescargas, $InicioEnlaces, $FinEnlaces, $Anterior, $Siguiente, $InicioEncabezado, $FinEncabezado, $InicioPie, $FinPie, $InicioEncabezadoComentario, $FinEncabezadoComentario, $InicioComentario, $FinComentario, $BloquearImagenesSubidas, $BloquearComentarios, $InicioFoto, $FinFoto, $InicioFotoGrande, $FinFotoGrande, $InicioMarcoFoto, $FinMarcoFoto, $VerVisitas, $VerFecha, $TemaCargado, $FotoDescripcion, $UsarGraficoEnNombre, $AleatorioListado, $PermitirImprimir, $PermitirMail, $NombreFotoCarpeta, $NombreFotoCarpetaSuperior, $BordeImagenIzquierda, $BordeImagenDerecha, $BordeImagenArriba, $BordeImagenAbajo, $UsarBordes, $BordesTema, $BordeImagenPequenoIzquierda, $BordeImagenPequenoDerecha, $BordeImagenPequenoArriba, $BordeImagenPequenoAbajo, $BordeImagenGrandeIzquierdaArriba, $BordeImagenGrandeIzquierdaCentro, $BordeImagenGrandeIzquierdaAbajo, $BordeImagenGrandeCentroArriba, $BordeImagenGrandeCentroAbajo, $BordeImagenGrandeDerechaArriba, $BordeImagenGrandeDerechaCentro, $BordeImagenGrandeDerechaAbajo, $SobreFoto, $BajoFoto, $UsarBordesBloque, $UsarBordesGaleria, $UsarBordesImagenGrande, $NombreFrameStyleBlock, $NombreFrameStyleGaleria, $NombreFrameStyleImagenGrande, $TamanoMaximoFichero, $ForzarDescripcion, $ForzarTamano, $EspaciadoVertical, $EspaciadoHorizontal, $Espaciado, $ColorFondo, $ColorFondo1, $ColorFondo2, $ColorFondo3, $ColorFondo4, $EspaciadoInterno){



global $xoopsDB, $xoopsConfig, $xoopsTheme, $xoopsUser, $myts;

	
	$query = "update ". $xoopsDB->prefix("uskolag_carpeta")." set Carpeta='$Carpeta', Imagen='$Imagen', Descripcion='$Descripcion', Aleatorio='$Aleatorio', Bloque='$Bloque', MCatalogos='$MCatalogos', AnchoBloque='$AnchoBloque', AltoBloque='$AltoBloque', AnchoImagenes='$AnchoImagenes', AltoImagenes='$AltoImagenes', FotosAncho='$FotosAncho', FotosAlto='$FotosAlto', EnviarFicheros='$EnviarFicheros', EnviarComentarios='$EnviarComentarios',  EnviarVotaciones='$EnviarVotaciones', EnviarEnlaces='$EnviarEnlaces', NecesarioRegistrar='$NecesarioRegistrar', InicioDescargas='$InicioDescargas', FinDescargas='$FinDescargas', InicioEnlaces='$InicioEnlaces',	FinEnlaces='$FinEnlaces', Anterior='$Anterior', Siguiente='$Siguiente', InicioEncabezado='$InicioEncabezado', FinEncabezado='$FinEncabezado', InicioPie='$InicioPie', FinPie='$FinPie', InicioEncabezadoComentario='$InicioEncabezadoComentario', FinEncabezadoComentario='$FinEncabezadoComentario', InicioComentario='$InicioComentario', FinComentario='$FinComentario', BloquearImagenesSubidas='$BloquearImagenesSubidas', BloquearComentarios='$BloquearComentarios', InicioFoto='$InicioFoto', FinFoto='$FinFoto', InicioFotoGrande ='$InicioFotoGrande', FinFotoGrande='$FinFotoGrande', InicioMarcoFoto='$InicioMarcoFoto', FinMarcoFoto='$FinMarcoFoto', VerVisitas='$VerVisitas', VerFecha='$VerFecha', TemaCargado='$TemaCargado', FotoDescripcion='$FotoDescripcion', UsarGraficoEnNombre='$UsarGraficoEnNombre', AleatorioListado='$AleatorioListado', PermitirImprimir='$PermitirImprimir', PermitirMail='$PermitirMail', NombreFotoCarpeta='$NombreFotoCarpeta', NombreFotoCarpetaSuperior='$NombreFotoCarpetaSuperior',	BordeImagenIzquierda = '$BordeImagenIzquierda', BordeImagenDerecha='$BordeImagenDerecha', BordeImagenArriba='$BordeImagenArriba', BordeImagenAbajo='$BordeImagenAbajo', UsarBordes='$UsarBordes', BordesTema='$BordesTema', BordeImagenPequenoIzquierda= '$BordeImagenPequenoIzquierda', BordeImagenPequenoDerecha= '$BordeImagenPequenoDerecha', BordeImagenPequenoArriba='$BordeImagenPequenoArriba', BordeImagenPequenoAbajo='$BordeImagenPequenoAbajo', BordeImagenGrandeIzquierdaArriba='$BordeImagenGrandeIzquierdaArriba', BordeImagenGrandeIzquierdaCentro='$BordeImagenGrandeIzquierdaCentro', BordeImagenGrandeIzquierdaAbajo='$BordeImagenGrandeIzquierdaAbajo', BordeImagenGrandeCentroArriba='$BordeImagenGrandeCentroArriba', BordeImagenGrandeCentroAbajo='$BordeImagenGrandeCentroAbajo', BordeImagenGrandeDerechaArriba='$BordeImagenGrandeDerechaArriba', BordeImagenGrandeDerechaCentro='$BordeImagenGrandeDerechaCentro', BordeImagenGrandeDerechaAbajo='$BordeImagenGrandeDerechaAbajo' , SobreFoto='$SobreFoto', BajoFoto='$BajoFoto', UsarBordesBloque='$UsarBordesBloque', UsarBordesGaleria='$UsarBordesGaleria', UsarBordesImagenGrande='$UsarBordesImagenGrande', NombreFrameStyleBlock='$NombreFrameStyleBlock', NombreFrameStyleGaleria='$NombreFrameStyleGaleria', NombreFrameStyleImagenGrande='$NombreFrameStyleImagenGrande', TamanoMaximoFichero='$TamanoMaximoFichero', ForzarDescripcion='$ForzarDescripcion', ForzarTamano='$ForzarTamano', EspaciadoVertical='$EspaciadoVertical', EspaciadoHorizontal='$EspaciadoHorizontal', Espaciado='$Espaciado', ColorFondo='$ColorFondo', ColorFondo1='$ColorFondo1', ColorFondo2='$ColorFondo2', ColorFondo3='$ColorFondo3', ColorFondo4='$ColorFondo4', EspaciadoInterno='$EspaciadoInterno' where ID=".$ID."";

    if(!$f_res = $xoopsDB->query($query))
     {
		die("Error <br />$sql");
     }


}



?>