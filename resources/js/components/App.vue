<template>
    <div class="container">
        <div id="corpo_principal">
            <h1>Manter Operadora</h1>
            <hr>
            <div id="interno">
                <table id="selects">
                    <tr>
                        <td>Listar Operadora</td>
                        <td>Status</td>
                    </tr>
                    <tr>
                        <td>
                            <b-form-select v-model="selected1" @change="selecionarOperadora($event)">Listar Operadora
                                <b-form-select-option v-bind:value='todos'>Todas</b-form-select-option>
                                <b-form-select-option v-for="(operadora,index) in operadoras" :key="operadora.id"
                                                      v-bind:value="operadora.nome">{{ operadora.nome }}
                                </b-form-select-option>
                            </b-form-select>
                        </td>
                        <td>
                            <b-form-select v-model="selected2" :options="options">Status</b-form-select>
                        </td>
                    </tr>
                </table>



                <b-button pill variant="outline-success" id="show-btn" @click="$bvModal.show('bv-modal-cadastro')">
                    <b-icon icon="plus" scale="2" variant="outline-secondary"></b-icon> Novo
                </b-button>
                <br><br>

                <div id="tabela">
                    <div class="row linha">
                        <div class="coluna">Operadora</div>
                        <div class="coluna">Descrição</div>
                        <div class="coluna3">Ações</div>
                    </div>
                    <div class="linha" v-for="(operadora,index) in operadoras.filter((operadora) => operadora.nome.includes(selected1))" :key="operadora.id">
                        <Operadora :operadora="operadora" :filtro_status="selected2"
                                   @meDelete="deletarOperadora($event)" @meDesabilite="desabilitarOperadora($event)">
                        </Operadora>
                    </div>
                </div>

            </div>
        </div>

        <div>
            <b-modal id="bv-modal-cadastro" ref="bv-modal-cadastro" hide-footer @hidden="modalCadastroHide">
                <template #modal-title>
                    Cadastrar operadora
                </template>
                <div class="d-block">
                    <b-form-group id="group-1" label="Nome da Operadora:" label-for="input-1">
                        <b-form-input
                            id="input-1"
                            v-model="form.nome"
                            type="text"
                            placeholder="Digite o nome da Operadora"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="group-2" label="Descrição:" label-for="input-2">
                        <b-form-input
                            id="input-2"
                            v-model="form.descricao"
                            placeholder="Digite a descricao da Operadora"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-button pill variant="outline-success" class="mt-3" block @click="cadastrarOperadora()">Cadastrar</b-button>
                </div>
                <b-button class="mt-3" pill variant="outline-secondary" block @click="$bvModal.hide('bv-modal-cadastro')">Voltar</b-button>
            </b-modal>
        </div>

    </div>
</template>

<script>
import Operadora from "./Operadora";
export default {
    name: "App",
    components: {Operadora},
    data() {
        return {
            operadoras: [],
            _token: null,
            todos: '',
            selected1: '',
            selected2: null,
            form: {
                nome: '',
                descricao: '',
                _token: '',
            },
            options: [
                {text: 'Todos', value: null},
                {text: 'Ativas', value: 1},
                {text: 'Inativas', value: 0},
            ],
        }
    },
    created: function () {
        axios.get("http://localhost:8000/operadoras/").then(res => {
            this.operadoras = res.data;
        });
        axios.get("http://localhost:8000/token/").then(response => {
            this._token = response.data;
        });
    },

    methods: {
        selecionarOperadora: function ($event) {
            if ($event == 999) {
                this.inicioTabela = 0;
            } else {
                this.inicioTabela = $event - 1;
            }
        },
        cadastrarOperadora: function () {
            this.form._token = this._token;
            axios.post("http://localhost:8000/operadoras/", this.form).then(res => {
                this.operadoras.push(res.data);
                this.$refs['bv-modal-cadastro'].hide();

            })
        },
        deletarOperadora: function ($event) {
            var idDelete = $event.id;
            var newArray = this.operadoras.filter((operadora) => operadora.id != idDelete);
            this.operadoras = newArray;
        },
        desabilitarOperadora: function ($event) {
            var id = $event.id;
            var data = $event.res.data;
            var newArray = this.operadoras.filter((operadora) => operadora.id != id);
            this.operadoras = newArray;
            this.operadoras.push(data);
            console.log(data);
        },
        modalCadastroHide: function(){
            this.form.nome = '';
            this.form.descricao = '';
        },
    },
}


</script>

<style>
    #corpo_principal {
        width:100%;
        height: 70%;
        padding: 2%;
        background-color: #F8F8FF;
    }
    #interno {
        width:100%;
        padding: 2%;
        background-color: #ffffff;

    }
    #selects{
        margin-bottom: 20px;
    }
    #selects td {
        padding-right: 20px;
    }
    #table-operadoras{
        padding: 2%;
    }
    .botao{
        margin-right: 20px;
    }
    #tabela:before,
    #tabela:after{
        content: "";
        display: table;
    }
    .linha{
        width:1000px;
    }
    .coluna{
        width:30%;
        position: relative;
        left:0px;
        padding-left: 3%;
    }
    .coluna3{
        width:40%;
        position: relative;
        left:0px;
        padding-left: 3%;
    }
</style>
