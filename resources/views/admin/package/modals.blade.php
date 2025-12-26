<div class="modal fade" id="itenaryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Itenary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formIternary" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="package_id" value="{{$package_id}}">
                    <div class="form-group">
                        <label for="title">Day</label>
                        <input type="text" name="day" class="form-control" id="day" placeholder="Enter day" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="description"> Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Price Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPrice" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="package_id" value="{{$package_id}}">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label for="adult_single_share">Adult Single Share</label>
                            <input type="number" name="adult_single_share" class="form-control" id="adult_single_share"
                                   placeholder="Enter Adult Single Share" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="adult_double_share">Adult Double Share</label>
                            <input type="number" name="adult_double_share" class="form-control" id="adult_double_share"
                                   placeholder="Enter Adult Double Share" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="adult_trip_share">Adult Trip Share</label>
                            <input type="number" name="adult_trip_share" class="form-control" id="adult_trip_share"
                                   placeholder="Enter Adult Trip Share" required>
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="child_with_bed">Child with bed</label>
                            <input type="number" name="child_with_bed" class="form-control" id="child_with_bed"
                                   placeholder="Enter Child with bed" required>
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="child_without_bed">Child without bed</label>
                            <input type="number" name="child_without_bed" class="form-control" id="child_without_bed"
                                   placeholder="Enter Child without bed" required>
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="infant">Infance</label>
                            <input type="number" name="infant" class="form-control" id="infant"
                                   placeholder="Enter Infance" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hotelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Hotels</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formHotel" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="package_id" value="{{$package_id}}">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                   placeholder="Enter Name" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="Destination">Destination</label>
                            <input type="text" name="destination" class="form-control" id="destination"
                                   placeholder="Enter Destination" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="category">Category</label>
                            <input type="text" name="category" class="form-control" id="category"
                                   placeholder="Enter Category" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exclusionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Exclusion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formExclusion" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="package_id" value="{{$package_id}}">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="descriptionE">Description</label>
                            <textarea name="description" id="descriptionE" class="ckeditor">
                                </textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="inclusionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Inclusion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formInclusion" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="package_id" value="{{$package_id}}">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="descriptioI">Description</label>
                            <textarea name="description" id="descriptionI" class="ckeditor">
                                </textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTerms" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="package_id" value="{{$package_id}}">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="descriptioI">Description</label>
                            <textarea name="description" id="descriptionT" class="ckeditor">
                                </textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="visaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Visa Reqiurement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formVisa" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="package_id" value="{{$package_id}}">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="descriptioV">Description</label>
                            <textarea name="description" id="descriptionV" class="ckeditor">
                                </textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="OPTModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Operation Tour</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formOPT" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="package_id" value="{{$package_id}}">
                    <div class="form-group">
                        <label for="title">Destination</label>
                        <input type="text" name="destination" class="form-control" id="destinationO"
                               placeholder="Enter destination" required>
                    </div>
                    <div class="form-group">
                        <label for="price_per_adult">Price Per Adult</label>
                        <input type="number" name="price_per_adult" class="form-control" id="price_per_adult"
                               placeholder="Enter Price Per Adult" required>
                    </div>
                    <div class="form-group">
                        <label for="price_per_child">Price Per Child</label>
                        <input type="number" name="price_per_child" class="form-control" id="price_per_child"
                               placeholder="Enter Price Per Child" required>
                    </div>
                    <div class="form-group">
                        <label for="price_per_infant">Price Per Infant</label>
                        <input type="number" name="price_per_infant" class="form-control" id="price_per_infant"
                               placeholder="Enter Price Per Infant" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

