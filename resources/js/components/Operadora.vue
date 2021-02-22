<template>
    <div id="operadora" v-if="filtro_status == operadora.status || filtro_status == null">
        <table class="table table-striped">
            <tr>
                <td>{{ operadora.nome }}</td>
                <td>{{ operadora.descricao }}</td>
                <td class="tam3">
                    <b-button class="botao" v-if="operadora.status" pill variant="outline-warning" size="sm" @click="modalEditarShow()">
                        <b-icon icon="pencil" scale="1" variant="outline-secondary"></b-icon> Editar
                    </b-button>
                    <b-button class="botao" v-if="operadora.status" pill variant="outline-danger" size="sm" @click="$bvModal.show(newId)">
                        <b-icon icon="x-circle" scale="1" variant="outline-secondary"></b-icon> Excluir
                    </b-button>
                    <b-button class="botao" v-if="operadora.status" pill variant="outline-secondary" size="sm" @click="$bvModal.show(newId3)">
                        <b-icon icon="caret-down" scale="1"></b-icon> Desabilitar
                    </b-button>
                </td>
            </tr>
        </table>

        <div>
            <b-modal :id="newId2" ref="bv-modal-editar" hide-footer @hidden="modalEditarHide">
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
                <b-button class="mt-3" pill variant="outline-secondary" block @click="$bvModal.hide(newId2)">Voltar</b-button>
            </b-modal>
        </div>

        <div>
            <b-modal :id="newId" ref="bv-modal-excluir" hide-footer>
                <template #modal-title>
                    Tem certeza que deseja excluir essa Operadora?
                </template>
                <b-button pill variant="outline-danger" class="mt-3" block @click="excluirOperadora()">Excluir</b-button>
                <b-button class="mt-3" pill variant="outline-secondary" block @click="$bvModal.hide(newId)">Voltar</b-button>
            </b-modal>
        </div>

        <div>
            <b-modal :id="newId3" ref="bv-modal-desabilitar" hide-footer>
                <template #modal-title>
                    Tem certeza que deseja desabilitar essa Operadora?
                </template>
                Ao desabilitar este item você só poderá consulta-lo, mas não poderá mais reativá-lo.
                <b-button pill variant="outline-danger" class="mt-3" block @click="desabilitarOperadora()">Desabilitar</b-button>
                <b-button class="mt-3" pill variant="outline-secondary" block @click="$bvModal.hide(newId3)">Voltar</b-button>
            </b-modal>
        </div>
    </div>

</template>

<script>
export default {
name: "Operadora",
    data(){
        return{
            _token: null,
            formEditar:{
                id:'',
                nome:'',
                descricao:'',
                _token:'',
            }
        }
    },
    created: function () {
        axios.get("http://localhost:8000/token/").then(response => {
            this._token = response.data;
        });
    },

    props: {
        operadora:Object,
        filtro_status: "",
    },
    computed: {
        newId: function () {
            return this.operadora.nome + this.operadora.id;
        },
        newId2: function () {
            return this.operadora.nome + this.operadora.id+'edit';
        },
        newId3: function () {
            return this.operadora.nome + this.operadora.id+'desabilite';
        },
    },

    methods: {
        excluirOperadora: function () {
            axios.delete("http://localhost:8000/operadoras/" + this.operadora.id).then(res => {
                if (res.status = 204) {
                    this.$emit("meDelete",{"id": this.operadora.id,component:this});
                }
                this.$refs['bv-modal-excluir'].hide();
            });
        },

        desabilitarOperadora: function(){
            var form = {
                _token: this._token,
                status: 0,
            }
            axios.put("http://localhost:8000/operadoras/"+this.operadora.id,form).then(res => {
                this.$emit("meDesabilite",{"id": this.operadora.id,res});
            });
            this.$refs['bv-modal-desabilitar'].hide();
        },
        editarOperadora: function(){
            axios.put("http://localhost:8000/operadoras/"+this.operadora.id,this.formEditar).then(res => {
                this.operadora = res.data;
            });
            this.$refs['bv-modal-editar'].hide();
        },

        modalEditarHide: function(){
            this.formEditar.nome = '';
            this.formEditar.descricao = '';
        },

        modalEditarShow: function($id){
            this.formEditar.id = this.operadora.id;
            this.formEditar.nome = this.operadora.nome;
            this.formEditar.descricao = this.operadora.descricao;
            this.formEditar._token = this._token;
            this.$bvModal.show(this.newId2);
        }

    },


}
</script>

<style scoped>
    td {
        width: 30%;
    }
    .tam3{
        width:40%;
    }
</style>
