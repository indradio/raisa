$('#rsvBataldl').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var rsv_id = button.data('rsv_id') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-body input[name="id"]').val(rsv_id)
})

$('#revEdit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var revmenu = button.data('nama') // Extract info from data-* attributes
    var revjanuari = button.data('januari')
    var revfebruari = button.data('februari')
    var revmaret = button.data('maret')
    var revapril = button.data('april')
    var revmei = button.data('mei')
    var revjuni = button.data('juni')
    var revjuli = button.data('juli')
    var revagustus = button.data('agustus')
    var revseptember = button.data('september')
    var revoktober = button.data('oktober')
    var revnovember = button.data('november')
    var revdesember = button.data('desember')
    var modal = $(this)
    modal.find('.modal-body input[name="nama"]').val(revmenu)
    modal.find('.modal-body input[name="januari"]').val(revjanuari)
    modal.find('.modal-body input[name="februari"]').val(revfebruari)
    modal.find('.modal-body input[name="maret"]').val(revmaret)
    modal.find('.modal-body input[name="april"]').val(revapril)
    modal.find('.modal-body input[name="mei"]').val(revmei)
    modal.find('.modal-body input[name="juni"]').val(revjuni)
    modal.find('.modal-body input[name="juli"]').val(revjuli)
    modal.find('.modal-body input[name="agustus"]').val(revagustus)
    modal.find('.modal-body input[name="september"]').val(revseptember)
    modal.find('.modal-body input[name="oktober"]').val(revoktober)
    modal.find('.modal-body input[name="november"]').val(revnovember)
    modal.find('.modal-body input[name="desember"]').val(revdesember)
})

