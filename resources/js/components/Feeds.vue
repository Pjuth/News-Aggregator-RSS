<template>
    <div class="container">
        <div class="row">
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="filter">
                    <select v-model="selectedCategory">
                        <option value="Visi"> Visi</option>
                        <option v-for="cat in getCategories">{{ cat }}</option>
                    </select>
                </div>
                <ul class="nav">
                    <li v-if="currentPage > 1"><a @click="currentPage--"><<</a></li>
                    <li v-for="pageNumber in totalPages"
                        v-if="Math.abs(pageNumber - currentPage) < 2 || pageNumber === totalPages || pageNumber === 1">
                        <a v-bind:key="pageNumber" @click="setPage(pageNumber)"
                           :class="{current: currentPage === pageNumber, last: (pageNumber === totalPages && Math.abs(pageNumber - currentPage) > 2),
                           first:(pageNumber === 1 && Math.abs(pageNumber - currentPage) > 2)}">{{ pageNumber }}</a>
                    </li>
                    <li v-if="currentPage < totalPages"><a @click="currentPage++">>></a></li>
                </ul>
                <div class="card-columns">
                    <div v-for="(feed, index) in paginate">
                        <div class="card text-center">
                            <h5 class="card-title" data-toggle="modal" :data-target="'#myModal' + index">
                                {{ feed.title }}</h5>
                            <p class="card-text">
                                <a v-bind:href="feed.link" target="_blank" type="button"
                                   class="btn btn-default">Plačiau...
                                </a>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">{{ time(feed.pubDate) }} - {{ feed.category }}</small>
                            </p>
                        </div>
                        <div class="modal fade" v-bind:id="['myModal'+index]" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{feed.title}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{ feed.description }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a v-bind:href="feed.link" target="_blank" type="button"
                                           class="btn btn-default">Plačiau...
                                        </a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Feeds",
        data() {
            return {
                feeds: [],
                currentPage: 1,
                itemsPerPage: 10,
                resultCount: 0,
                selectedCategory: "Visi",
            }
        },
        created() {
            this.fetchFeeds();
        },
        methods: {
            fetchFeeds() {
                let page_url = '/api/feeds';
                fetch(page_url).then(res => res.json()).then(res => {
                    this.feeds = this.sortDate(res);
                }).catch(err => console.log(err));
            },
            setPage: function (pageNumber) {
                this.currentPage = pageNumber
            },
            time(time) {
                let minutes = '';
                let hours = '';
                let days = '';
                if (time < 60) {
                    minutes = time;
                } else if (time < 1440) {
                    hours = Math.floor(time / 60);
                    minutes = time - hours * 60;
                } else if (time > 1440) {
                    days = Math.floor(time / 1440);
                    hours = Math.floor((time - days * 1440) / 60);
                    minutes = time - days * 1440 - hours * 60;
                }
                return 'Paskelbta prieš ' + (days ? days + ' d. ' : '') + (hours ? hours + ' val. ' : '') + minutes + ' min.';
            },
            sortDate(arr) {
                return arr.slice().sort(function (a, b) {
                    return a.pubDate - b.pubDate;
                })
            },
        },
        computed: {
            totalPages: function () {
                return Math.ceil(this.resultCount / this.itemsPerPage)
            },
            paginate() {
                let target = this.filteredFeeds;
                if (!target || target.length !== target.length) {
                    return
                }
                this.resultCount = target.length;
                let index = this.currentPage * this.itemsPerPage - this.itemsPerPage;
                if (index < 0) {
                    index = 0
                }
                return target.slice(index, index + this.itemsPerPage)
            },
            filteredFeeds: function () {
                let vm = this;
                let category = vm.selectedCategory;
                if (category === "Visi") {
                    return vm.feeds;
                } else {
                    return vm.feeds.filter(function (feed) {
                        return (category === 'Visi' || feed.category === category);
                    });
                }
            },
            getCategories() {
                let a = [];
                this.feeds.forEach(function (feed) {
                    a.push(feed.category);
                });
                return a.filter(function (elem, pos, arr) {
                    return arr.indexOf(elem) === pos;
                });
            },
        },
    }
</script>

<style scoped>
    a {
        color: #999;
    }

    .current {
        color: red !important;
    }

    ul {
        padding: 0;
        list-style-type: none;
    }

    li {
        display: inline;
        margin: 5px 5px;
    }

    a.first::after {
        content: '... '
    }

    a.last::before {
        content: ' ...'
    }

    .modal {
        text-align: center;
        padding: 0 !important;
    }

    .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
    }

    .nav li {
        color: blue;
        text-decoration: underline;
        cursor: pointer;
    }

    .card h5 {
        cursor: pointer;
        padding: 10px;
    }
</style>