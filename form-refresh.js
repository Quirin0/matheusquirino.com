
// para evitar reenviar formulario ao apertar para voltar ou dar reload na página
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
