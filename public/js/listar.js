//preciso colocar toda minha lógica dentro desta arrow function que é executada quando toda a página é carregada
document.addEventListener("DOMContentLoaded", () => {


    let mark_all = document.getElementById('mark_all')
    mark_all.addEventListener('change', () => {
        let checkboxes = document.querySelectorAll('.selecionar')

        checkboxes.forEach(checkbox => {
            console.log(checkbox.checked)
            console.log(mark_all.checked)
            if (checkboxes.checked !== mark_all.checked) {
                checkbox.checked = mark_all.checked

                if (checkbox.checked) {
                    document.getElementById('order_nome').style.display = 'block'
                }
                else {
                    document.getElementById('order_nome').style.display = 'none'
                }

            }
        });
    })

    let all_registers = document.getElementById('all_registers');
    all_registers.addEventListener('click', () => {
        let input_qtd = document.getElementById('qtd')

        if (all_registers.checked) {
            input_qtd.value = ''
            input_qtd.disabled = true
        }
        else {
            input_qtd.disabled = false
        }
    })


    let campo_nome = document.getElementById('nome')

    campo_nome.addEventListener('change', () => {
        if (campo_nome.checked) {
            document.getElementById('order_nome').style.display = 'block'
        }
        else {
            document.getElementById('order_nome').style.display = 'none'
        }
    })

})