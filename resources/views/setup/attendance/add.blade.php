<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 100%;margin:0;padding:0;height:100%;background:#f7f0ff;">
        <div class="modal-heading">
            <div class="center">
                {{-- <h3>Add {{ $name }}</h3> --}}
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        
        <div class="rows">
            <div class="c-9">
                <div class="rows">
                    <div class="c-4"></div>
                    {{-- Events  --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="events">Select Events</label>
                            <select name="events" id="events" class="select-small">
                                <option value="">Select Events</option>
                                {{-- options will be import dynamically --}}
                            </select>
                            <span class="error" id="events_error"></span>
                        </div>
                    </div>
                    {{-- Date --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="date">Date<span class="required" title="Required">*</span></label>
                            <input type="date" name="date" class="input-small" id="date" value="{{ date('Y-m-d') }}" disabled>
                            <span class="error" id="date_error"></span>
                        </div>
                    </div>
                    {{-- form part start --}}
                    <div class="c-4"></div>
                    <div class="c-8">
                        <form id="AddForm" method="POST" enctype="multipart/form-data" style="border: none;">
                            @csrf
                            @method('POST')
                            {{-- QR Url --}}
                            <div class="form-input-group">
                                <label for="qr_url">QR Url <span class="required" title="Required">*</span></label>
                                <input type="text" name="qr_url" class="form-input" id="qr_url" autofocus autocomplete="off">
                                <span class="error" id="qr_url_error"></span>
                            </div>
                            <div class="center">
                                <button type="submit" class="btn-blue hidden" id="Insert">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- show count --}}
            <div class="c-3">
                <table style="margin-top:20px;" class="data-table">
                    <caption style="background:#270fa5a8;">Atendence Count</caption>
                    <tbody>
                        <tr>
                            <td rowspan="2">Male</td>
                            <td>Graduate</td>
                            <td id="male_grad" style="text-align: right;">0</td>
                            <td rowspan="2" id="tot_male" style="text-align: right;">0</td>
                        </tr>
                        <tr>
                            <td>Pro-master</td>
                            <td id="male_pro" style="text-align: right;">0</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Female</td>
                            <td>Graduate</td>
                            <td id="female_grad" style="text-align: right;">0</td>
                            <td rowspan="2" id="tot_female" style="text-align: right;">0</td>
                        </tr>
                        <tr>
                            <td>Pro-master</td>
                            <td id="female_pro" style="text-align: right;">0</td>
                        </tr>
                        <tr>
                            <td colspan="3">Others</td>
                            <td id="other" style="text-align: right;">0</td>
                        </tr>
                        <tr>
                            <th colspan="3">Total</th>
                            <th id="tot" style="text-align: right;">0</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="c-12 center-col" id="userData">
                {{-- <iframe src="#" title="description" id="profileShow"></iframe> --}}
            </div>

            <div class="c-8"></div>
            
        </div>
    </div>
</div>
