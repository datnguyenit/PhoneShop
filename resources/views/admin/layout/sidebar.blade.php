            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="{{route('getadminindex')}}"><i class="fa fa-fw fa-dashboard"></i> Home</a>
                    </li>
                    <li>
                        <a href="{{route('getadminuser')}}"><i class="fa fa-fw fa-bar-chart-o"></i> User Manager</a>
                    </li>
                    <li>
                        <a href="{{route('getadminproduct')}}"><i class="fa fa-fw fa-table"></i> Products</a>
                    </li>

                     <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#bill"><i class="fa fa-fw fa-arrows-v"></i> Bills <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="bill" class="collapse">
                            <li>
                                <a href="{{route('getadminbill')}}">Waiting bills</a>
                            </li>
                            <li>
                                <a href="{{route('getadmincancel')}}">Canceled bills</a>
                            </li>
                            <li>
                                <a href="{{route('getadminreceipt')}}">Receipts</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#import"><i class="fa fa-fw fa-arrows-v"></i> Imports <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="import" class="collapse">
                            <li>
                                <a href="{{route('getadminimport')}}">Waiting Imports</a>
                            </li>
                            <li>
                                <a href="{{route('getlistimportcanceled')}}">Canceled Imports</a>
                            </li>
                            <li>
                                <a href="{{route('getlistimportpaid')}}">Paid Imports</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#export"><i class="fa fa-fw fa-arrows-v"></i> Exports <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="export" class="collapse">
                            <li>
                                <a href="{{route('getwaitingreceipt')}}">Waiting Receipts</a>
                            </li>
                            <li>
                                <a href="{{route('getexportreceipt')}}">Exported Receipts</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{route('getstatisticproduct')}}"><i class="fa fa-fw fa-wrench"></i> Statistic</a>
                    </li>
                    
                    <li >
                        <a href="{{route('index')}}"><i class="fa fa-fw fa-file"></i> Client Page</a>
                    </li>
                    <li>
                        <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                    </li>
                </ul>
            </div>