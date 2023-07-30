@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-close-mask{
            z-index: 2099;
        }
        .select2-dropdown{
            z-index: 3051;
        }
    </style>
@endpush

@extends('layouts.app')
@section('content')
    <div class="main_content">
        <div class="category-title">
            <h4>Мой магазин</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="store">
                    <div class="market_lists">
                        <div v-for="(item) in marketplaces" :key="item.id" class="market">
                            <div class="market_logo">
                                <img :src="'/uploads/admin/'+item.logo" :alt="item.name">
                            </div>
                            <div class="market_settings">
                                <button @click="getSettingPriceWindow(item.id)" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <svg width="20" height="21" viewBox="0 0 20 21" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.214 13.0413L17.752 11.7913C17.8212 11.3672 17.8569 10.9342 17.8569 10.5011C17.8569 10.0681 17.8212 9.63505 17.752 9.21094L19.214 7.96094C19.3243 7.86653 19.4033 7.74079 19.4403 7.60044C19.4774 7.46009 19.4709 7.31178 19.4216 7.17522L19.4015 7.11719C18.999 5.99225 18.3963 4.94941 17.6225 4.03906L17.5823 3.99219C17.4885 3.88181 17.3634 3.80247 17.2235 3.76462C17.0836 3.72676 16.9356 3.73217 16.7989 3.78013L14.9841 4.42522C14.3145 3.87612 13.5667 3.44308 12.7587 3.13951L12.4082 1.24219C12.3818 1.09942 12.3125 0.968086 12.2097 0.86562C12.1068 0.763154 11.9752 0.694412 11.8323 0.668527L11.7721 0.657366C10.6091 0.447545 9.38592 0.447545 8.22297 0.657366L8.16271 0.668527C8.01984 0.694412 7.88824 0.763154 7.78537 0.86562C7.68251 0.968086 7.61325 1.09942 7.58681 1.24219L7.23414 3.14844C6.43255 3.45207 5.68607 3.88488 5.02431 4.42969L3.19619 3.78013C3.05951 3.73179 2.91135 3.72618 2.7714 3.76406C2.63146 3.80194 2.50635 3.88151 2.41271 3.99219L2.37253 4.03906C1.59964 4.95005 0.997028 5.99272 0.59351 7.11719L0.573421 7.17522C0.472975 7.45424 0.555564 7.76674 0.78101 7.96094L2.26092 9.22433C2.19172 9.64397 2.15824 10.0725 2.15824 10.4989C2.15824 10.9275 2.19172 11.356 2.26092 11.7734L0.78101 13.0368C0.670733 13.1312 0.591806 13.257 0.554725 13.3973C0.517643 13.5377 0.524164 13.686 0.573421 13.8225L0.59351 13.8806C0.997528 15.0056 1.59574 16.0435 2.37253 16.9587L2.41271 17.0056C2.50658 17.116 2.63169 17.1953 2.77155 17.2332C2.91141 17.271 3.05946 17.2656 3.19619 17.2176L5.02431 16.5681C5.68949 17.115 6.4328 17.548 7.23414 17.8493L7.58681 19.7556C7.61325 19.8983 7.68251 20.0297 7.78537 20.1321C7.88824 20.2346 8.01984 20.3034 8.16271 20.3292L8.22297 20.3404C9.39661 20.5513 10.5984 20.5513 11.7721 20.3404L11.8323 20.3292C11.9752 20.3034 12.1068 20.2346 12.2097 20.1321C12.3125 20.0297 12.3818 19.8983 12.4082 19.7556L12.7587 17.8583C13.5664 17.5555 14.3184 17.121 14.9841 16.5725L16.7989 17.2176C16.9356 17.266 17.0837 17.2716 17.2237 17.2337C17.3636 17.1958 17.4887 17.1163 17.5823 17.0056L17.6225 16.9587C18.3993 16.0413 18.9975 15.0056 19.4015 13.8806L19.4216 13.8225C19.5221 13.548 19.4395 13.2355 19.214 13.0413ZM16.1672 9.47433C16.223 9.81138 16.252 10.1574 16.252 10.5033C16.252 10.8493 16.223 11.1953 16.1672 11.5324L16.0198 12.4275L17.6873 13.8538C17.4345 14.4361 17.1154 14.9874 16.7364 15.4967L14.6649 14.7623L13.964 15.3382C13.4306 15.7757 12.8368 16.1194 12.194 16.3605L11.3435 16.6797L10.944 18.8449C10.3135 18.9163 9.67706 18.9163 9.04663 18.8449L8.64708 16.6752L7.80333 16.3516C7.16717 16.1105 6.57565 15.7667 6.04664 15.3315L5.34574 14.7533L3.26092 15.4944C2.88146 14.9833 2.56449 14.4319 2.31003 13.8516L3.9953 12.4118L3.85021 11.519C3.79664 11.1864 3.76762 10.8426 3.76762 10.5033C3.76762 10.1618 3.7944 9.82031 3.85021 9.48772L3.9953 8.59487L2.31003 7.15513C2.56226 6.57254 2.88146 6.02344 3.26092 5.51228L5.34574 6.25335L6.04664 5.67522C6.57565 5.23996 7.16717 4.89621 7.80333 4.65513L8.64931 4.33594L9.04887 2.16629C9.6761 2.09487 10.3167 2.09487 10.9462 2.16629L11.3457 4.33147L12.1962 4.65067C12.8368 4.89174 13.4328 5.23549 13.9663 5.67299L14.6672 6.24888L16.7386 5.51451C17.1181 6.02567 17.435 6.57701 17.6895 7.15737L16.0221 8.5837L16.1672 9.47433ZM9.99976 6.35156C7.83012 6.35156 6.07119 8.11049 6.07119 10.2801C6.07119 12.4498 7.83012 14.2087 9.99976 14.2087C12.1694 14.2087 13.9283 12.4498 13.9283 10.2801C13.9283 8.11049 12.1694 6.35156 9.99976 6.35156ZM11.7676 12.048C11.5357 12.2805 11.2602 12.4649 10.9568 12.5906C10.6534 12.7162 10.3281 12.7806 9.99976 12.7801C9.33235 12.7801 8.70512 12.519 8.2319 12.048C7.99937 11.8161 7.81497 11.5406 7.68932 11.2372C7.56367 10.9338 7.49925 10.6085 7.49976 10.2801C7.49976 9.61272 7.76092 8.98549 8.2319 8.51228C8.70512 8.03906 9.33235 7.78013 9.99976 7.78013C10.6672 7.78013 11.2944 8.03906 11.7676 8.51228C12.0002 8.74415 12.1846 9.01971 12.3102 9.3231C12.4359 9.6265 12.5003 9.95175 12.4998 10.2801C12.4998 10.9475 12.2386 11.5748 11.7676 12.048Z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    @include('store.category_lists')

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" style="overflow: hidden" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="width: 700px; height: 300px;">
                                <div class="modal-header" style="border-bottom: none;">
                                    <h5 v-html="windowTitle" class="modal-title" id="staticBackdropLabel">

                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <select style="width: 100%; " id="mySelect2" v-model="category_id" class="js-example-placeholder-single form-control">
                                        <option v-for="(item) in categories" :key="item.id" :value="item.id">@{{ item.name }}</option>
                                    </select>
                                    <div class="market_margin">
                                        <div style="font-size: 22px; color: #373946;font-weight: bold;">Введите наценку</div>
                                        <div>
                                            <div class="input-group mb-3">
                                                <input type="number" v-model="margin" min="20" max="300" class="form-control" placeholder="0" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="justify-content: space-between !important;border-top: none;">
                                    <button style="background-color: #fff;border-color: #D6D8DC;border-radius: 12px;width: 30%;color: #39C874;" type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Отмена</button>
                                    <button @click="saveMarketCategoryMargin()" style="background-color: #39C874;border-color: #39C874;border-radius: 10px;width: 30%;" type="button" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.toast')
@stop

@push('scripts')
    <!-- DataTables -->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        new Vue({
            el: '#wrap',
            data () {
                return {
                    toastHtml: '',
                    toastSuccess: false,
                    windowTitle: 'Настройки цен',
                    categories: [],
                    category_id: null,
                    margin: 0,
                    marketplaces: [],
                    market_id: null,
                }
            },
            methods: {
                getSettingPriceWindow(market_id){
                    for(let i = 0; i < this.marketplaces.length; i++) {
                        if(this.marketplaces[i].id === market_id) {
                            this.market_id = market_id;
                            let img = "/uploads/admin/" + this.marketplaces[i].logo;
                            this.windowTitle = '<img style="margin-right: 20px;" src="'+img+'">Настройки цен';
                        }
                    }
                },
                getCategoryList(){
                    axios.get('/get-categories-list')
                    .then(res => {
                        console.log(res);
                        this.categories = res.data;
                    })
                    .catch(err => {
                        console.log(err);
                    })
                },
                getMarketPlacesList(){
                    axios.get('/get-marketplaces')
                        .then(res => {
                            console.log(res);
                            this.marketplaces = res.data;
                        })
                        .catch(err => {
                            console.log(err);
                        })
                },
                saveMarketCategoryMargin(){
                    this.category_id = $('#mySelect2').val();
                    console.log('cat_id', this.category_id);
                    let formData = new FormData();
                    formData.append('marketplace_id', this.market_id);
                    formData.append('category_id', this.category_id);
                    formData.append('margin', this.margin);

                    axios.post('marketplace/category/margins', formData)
                    .then(res => {
                        console.log(res);
                        $("#staticBackdrop").modal('hide');
                        this.toastHtml = res.data;
                        this.toastSuccess = true;
                    })
                    .catch(err => {
                        console.log(err)
                    })
                }
            },
            created(){
                this.getCategoryList();
                this.getMarketPlacesList();
            }
        });
    </script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('#mySelect2').select2({
                placeholder: "Выберите категорию",
            });

            $("#cat_table").DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "/dist/Russian.json"
                }
            });

        });

    </script>
@endpush
