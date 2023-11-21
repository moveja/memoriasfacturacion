<div>
<script>
    var listener = new window.keypress.Listener();

    listener.simple_combo("f6", function() {
        console.log('f6')
        livewire.emit('saveSale')
    })
    listener.simple_combo("f8", function() {
        document.getElementById('cash').values =''
        document.getElementById('hiddenTotal').value=''
        document.getElementById('cash').focus()
    })
    listener.simple_combo("f4", function() {
        var total = parseFloat(document.getElementById('hiddenTotal').value)
        if(total > 0){
            Confirm(0, 'clearCart', '¿SEGUR@ DE ELIMINAR EL CARRITO?')
        }else{
            noty('AGREGA PRODUCTOS A LA VENTA')
        }
    })
</script>

<!---->
</div>