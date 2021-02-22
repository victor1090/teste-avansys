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

                <b-alert id="alert_error" show variant="danger" v-show="exibirErro">{{mensagemErro}}</b-alert>
                <div id="tabela">
                    <table class="table table-bordered" id="table-operadoras">
                        <tr>
                            <th>Operadora</th>
                            <th>Descrição</th>
                            <th colspan="3">Ações</th>
                        </tr>
                        <tr v-for="(operadora,index) in operadoras.filter((operadora) => operadora.nome.includes(selected1))" :key="operadora.id">
                            <td v-if="selected2 == null || selected2 == operadora.status">{{ operadora.nome }}</td>
                            <td v-if="selected2 == null || selected2 == operadora.status">{{ operadora.descricao }}</td>

                            <td colspan="3" v-if="selected2 == null || selected2 == operadora.status">
                                <b-button class="botao" v-if="operadora.status" pill variant="outline-warning" size="sm" @click="modalEditarShow(operadora.id)">
                                    <b-icon icon="pencil" scale="1" variant="outline-secondary"></b-icon> Editar
                                </b-button>
                                <b-button class="botao" v-if="operadora.status" pill variant="outline-danger" size="sm" @click="setarId(operadora.id,'excluir')">
                                    <b-icon icon="x-circle" scale="1" variant="outline-secondary"></b-icon> Excluir
                                </b-button>
                                <b-button class="botao" v-if="operadora.status" pill variant="outline-secondary" size="sm" @click="setarId(operadora.id,'desabilitar')">
                                    <b-icon icon="caret-down" scale="1"></b-icon> Desabilitar
                                </b-button>
                            </td>
                        </tr>
                    </table>
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

        <div>
            <b-modal id="bv-modal-editar" ref="bv-modal-editar" hide-footer @hidden="modalEditarHide">
                <template #modal-title>
                    Editar operadora
                </template>
                <div class="d-block">
                    <b-form-group id="group-1" label="Nome da Operadora:" label-for="input-1">
                        <b-form-input
                            id="input-1"
                            v-model="formEditar.nome"
                            type="text"
                            placeholder="Digite o nome da Operadora"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="group-2" label="Descrição:" label-for="input-2">
                        <b-form-input
                            id="input-2"
                            v-model="formEditar.descricao"
                            placeholder="Digite a descricao da Operadora"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-button pill variant="outline-warning" class="mt-3" block @click="editarOperadora()">Editar</b-button>
                </div>
                <b-button class="mt-3" pill variant="outline-secondary" block @click="$bvModal.hide('bv-modal-editar')">Voltar</b-button>
            </b-modal>
        </div>

        <div>
            <b-modal id="bv-modal-excluir" ref="bv-modal-excluir" hide-footer @hidden="modalEditarHide">
                <template #modal-title>
                    Tem certeza que deseja excluir essa Operadora?
                </template>
                <b-button pill variant="outline-danger" class="mt-3" block @click="excluirOperadora()">Excluir</b-button>
                <b-button class="mt-3" pill variant="outline-secondary" block @click="$bvModal.hide('bv-modal-excluir')">Voltar</b-button>
            </b-modal>
        </div>

        <div>
            <b-modal id="bv-modal-desabilitar" ref="bv-modal-desabilitar" hide-footer @hidden="modalEditarHide">
                <template #modal-title>
                    Tem certeza que deseja desabilitar essa Operadora?
                </template>
                Ao desabilitar esta operadora, você só poderá consulta-lá, mas não poderá mais reativa-lá.
                <b-button pill variant="outline-danger" class="mt-3" block @click="desabilitarOperadora()">Desabilitar</b-button>
                <b-button class="mt-3" pill variant="outline-secondary" block @click="$bvModal.hide('bv-modal-desabilitar')">Voltar</b-button>
            </b-modal>
        </div>

    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            operadoras: [],
            _token: null,
            todos: '',
            selected1: '',
            selected2: null,
            exibirErro: false,
            mensagemErro: null,
            id_excluir: '',
            id_desabilitar: '',
            form: {
                nome: '',
                descricao: '',
                _token: '',
            },
            formEditar: {
                id: '',
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
        setarId: function($id,acao){
            if(acao == 'excluir'){
                this.id_excluir = $id;
                this.$refs['bv-modal-excluir'].show();
            }else{
                this.id_desabilitar = $id;
                this.$refs['bv-modal-desabilitar'].show();
            }
        },
        excluirOperadora: function () {
            axios.delete("http://localhost:8000/operadoras/" + this.id_excluir).then(res => {
                if (res.status = 204) {
                    var newArray = this.operadoras.filter((operadora) => operadora.id != this.id_excluir);
                    this.operadoras = newArray;
                } else {
                    this.exibirErro = true;
                    this.mensagemErro = "Erro ao excluir a Operadora.";
                }
            });
            this.$refs['bv-modal-excluir'].hide();
        },
        cadastrarOperadora: function () {
            this.form._token = this._token;
            axios.post("http://localhost:8000/operadoras/", this.form).then(res => {
                this.operadoras.push(res.data);
                this.$refs['bv-modal-cadastro'].hide();

            })
        },
        editarOperadora: function(){
            axios.put("http://localhost:8000/operadoras/"+this.formEditar.id,this.formEditar).then(res => {
                var newArray = this.operadoras.filter((operadora) => operadora.id != this.formEditar.id);
                this.operadoras = newArray;
                this.operadoras.push(res.data);
            });
            this.$refs['bv-modal-editar'].hide();
        },

        desabilitarOperadora: function(){
            var form = {
                _token: this._token,
                status: 0,
            }
            axios.put("http://localhost:8000/operadoras/"+this.id_desabilitar,form).then(res => {
                var newArray = this.operadoras.filter((operadora) => operadora.id != this.id_desabilitar);
                this.operadoras = newArray;
                this.operadoras.push(res.data);
            });
            this.$refs['bv-modal-desabilitar'].hide();
        },

        modalCadastroHide: function(){
            this.form.nome = '';
            this.form.descricao = '';
        },

        modalEditarHide: function(){
            this.formEditar.nome = '';
            this.formEditar.descricao = '';
        },

        modalEditarShow: function($id){
            var operadora = this.operadoras.filter((operadora) => operadora.id == $id);
            this.formEditar.id = operadora[0].id;
            this.formEditar.nome = operadora[0].nome;
            this.formEditar.descricao = operadora[0].descricao;
            this.formEditar._token = this._token;
            this.$refs['bv-modal-editar'].show();
        }

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
        width:90%;
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
</style>
