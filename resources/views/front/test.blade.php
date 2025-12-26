@extends('layouts.front')
@section('body')
    <style>
        p {
            margin-top: 1em;
            margin-bottom: 1em;
        }

        ul {
            list-style-type: disc !important;
            padding-left: 1em !important;
            margin-left: 1em;
        }
    </style>
    <div class="container">
        <h3 class="text-center" style="border-bottom: 1px solid red;">Terms And Conditions</h3>


        <p class="text-center bold">Important Notice General Disclaimer</p>
        <br>

        <p><strong>flightsgyani.com</strong> does not act as principal but makes arrangements with third-party vendors,
            such as, but not limited to airlines, hotels, cruise lines, railroads, car rental agencies, tour operators
            and consolidators, traveler assist service providers, insurance providers and activities suppliers (each a
            &quot;Travel Supplier&quot;) for travel-related services which include, without limitation, air
            transportation, lodging, and car rental (each a &quot;Service Element&quot;).</p>

        <p>By using this Site, you acknowledge that the rates offered by <strong>flightsgyani.com</strong> and affiliate
            companies are a result of negotiation between <strong>flightsgyani.com</strong> and the Travel Suppliers and
            include certain fees retained by them for their services, taxes and other charges. When booking with any
            Travel Supplier thru this Site, you authorize <strong>flightsgyani.com</strong> and affiliate companies to
            book reservations or enter a contract on your behalf with Travel Suppliers for the total price displayed,
            including such fees and any applicable taxes or charges related to the Travel Supplier&#39;s or <strong>flightsgyani.com</strong>&#39;s
            services.</p>

        <p><strong>flightsgyani.com</strong> shall not be liable for errors or inaccuracies on the Site, or the failure
            of Travel Suppliers from whom you obtain services through this Site, including but not limited to airlines,
            hotels, cruise lines, railroads, car rental agencies, tour operators and consolidators, vacation packages,
            activities suppliers, traveler assist service providers and insurance providers.
            <strong>flightsgyani.com</strong>, in providing travel management services, does not endorse, guarantee or
            insure the products or services which are provided by an external supplier, the financial position of such
            suppliers or the reimbursement to you from any loss as a result of the financial condition of such supplier.
            In the event that a supplier defaults prior to providing the service to you where a payment has been made,
            your sole recourse for a refund shall be the defaulting supplier, from insurance covering such defaults if
            any, or from other responsible third party unless such loss was caused solely by
            <strong>flightsgyani.com</strong>. In those situations in which a supplier defaults prior to providing
            services you may pursue any recourse against the supplier for a refund, as permitted by law or statute.</p>

        <p>Except as expressly stated herein, <strong>flightsgyani.com</strong> assumes no responsibility for actions
            relating to travel services beyond the control of <strong>flightsgyani.com</strong> or its employees.
            <strong>flightsgyani.com</strong> is not responsible or liable for any act, error, omission, injury, loss,
            accident, damage, delay, nonperformance, irregularity, or any consequence thereof, which may be occasioned
            through neglect, or default or any other act or inaction of any Travel Supplier.
            <strong>flightsgyani.com</strong> shall not be liable for any fluctuation in price or change in schedule or
            equipment or accommodations for any travel service, which occurs subsequent to booking and payment for such
            service. <strong>flightsgyani.com</strong> shall not be liable for any cancellation, overbooking, delay,
            re-routing, strike, any weather occurrence or governmental occurrence as it affects your travel reservation
            made with us. <strong>flightsgyani.com</strong> shall not be liable for the depiction of travel products and
            services made available by any supplier of travel products and services, including but not limited to
            photographs, listed amenities, ratings, and discounts.</p>

        <p><strong>flightsgyani.com</strong> acts as a service that provides value added service to retail travel agents
            and consumers. <strong>flightsgyani.com</strong> has no control over and assumes no liability for the
            actions of the suppliers from whom it obtains travel products or services.</p>

        <p><strong>flightsgyani.com</strong> shall not be liable for final currency conversion or rates when paid after
            a travel reservation is made with us for international travel products and services. You agree and
            acknowledge that currency rates vary and any quoted price on the Site in local currency is a guideline, and
            not binding on us or the Travel Supplier.</p>

        <p>Once certain travel reservations are made and paid for they may be completely non-refundable or there may be
            a penalty involved in cancellation or seeking a refund from the supplier of travel products and services.
            Once tickets have been issued there may be a penalty involved for cancellations and refunds. We do not have
            control over printed prices on the tickets, although some tickets may have BT (bulk fare) printed on them,
            some may have a specific value on them, which may be different (lower or higher) than the fare
            collected.</p>

        <p>Discounts offered may vary depending on a number of factors including airlines utilized, class of service,
            destination, time of year (low, mid or high season), advance notice provided, minimum stay requirements
            fulfilled and flight load.</p>

        <p><strong>flightsgyani.com</strong> does not guarantee, endorse, validate or promote other advertiser&#39;s
            products and services that are advertised on our Site.</p>

        <p>By booking with us a contract may be formed between you and a Travel Supplier, and additional Terms &amp;
            Conditions may apply to your booking and purchase of travel-related goods and services. Please read the
            additional Terms &amp; Conditions provided by such Travel Supplier carefully. You hereby agree to be bound
            by all the Terms &amp; Conditions of purchase imposed by any Travel Supplier with whom you choose to
            contract, including, but not limited to, payment of all amounts when due and compliance with the Travel
            Supplier&#39;s rules and restrictions regarding availability and use of fares, products, or services. Some
            Travel Suppliers may require you to present a credit card or cash deposit upon check-in to cover additional
            expenses incurred during your stay or during the use of the reserved products or services. Such deposit is
            unrelated to any payment received by <strong>flightsgyani.com</strong> for your hotel, car or airline ticket
            booking. You understand that any violation of a Travel Supplier&#39;s rules and restrictions may result in
            the cancellation of your reservation(s), in denial of access to the respective Service Element or services,
            in your forfeiting any amount paid for such reservation(s), and/or in our debiting your account for any
            costs we incur as a result of such violation.</p>

        <p><br/>
            <!--[if !supportLineBreakNewLine]--><br/>
            <!--[endif]--></p>

        <p class="text-center bold">COMPASSION EXCEPTION POLICY (CEP)</p>

        <p>Certain customers may be eligible to receive a discount off cancellation, refund or ticket change service
            fees, as described in our Compassion Exception Policy (CEP) below:</p>


        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">Category</th>
                <th class="text-center">Eligibility Requirements</th>
                <th class="text-center">Exchange / Refund / Cancel</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Customers directly affected by severe weather, natural &nbsp; disaster or other uncontrollable
                    event
                </td>
                <td>If airline is waiving change/cancel fees, we will follow; &nbsp; If carrier has not announced waiver
                    policy , refund &nbsp; has to be processed as per airline rules.
                </td>
                <td>
                    100% discount off our cancellation, refund or ticket &nbsp; change service fees
                </td>
            </tr>
            <tr>
                <td>
                    Flight Cancellation
                </td>
                <td>
                    If airline is waiving change/cancel fees, we will follow; &nbsp; If carrier has not announced waiver
                    policy, change or refund has to be &nbsp; processed as per airline rules.
                </td>
                <td>
                    100% discount off our cancellation, refund or ticket &nbsp; change service fees
                </td>
            </tr>
            </tbody>
        </table>


        <p class="text-danger">Please note: The above CEP only applies to <strong>flightsgyani.com</strong>&#39;s own
            cancellation, refund or ticket change service fees. Customers may still be responsible for airline and/or
            other supplier imposed penalties, as well as any fare difference. <strong>flightsgyani.com</strong> does not
            control the policies of these airlines and/or other suppliers.</p>


        <p class="text-center bold">WAIVER</p>

        <p>By using the Site, you agree to irrevocably waive any claim against <strong>flightsgyani.com</strong>, its
            subsidiaries or affiliates, and any of such party&#39;s officers, directors, managers, agents, contractors,
            or employees, and expressly agree that neither <strong>flightsgyani.com</strong> nor any of its
            subsidiaries, affiliates, officers, directors, managers, agents, contractors or employees, shall be held
            liable for:</p>


        <ul>
            <li>any loss of or damage to property or injury to anyperson caused by reason of any defect, negligence, or
                other wrongful act of omission of, or any failure of performance of any kind by any Travel Supplier;
            </li>
            <li>any inconvenience, loss of enjoyment, mental distress or other similar matter;</li>
            <li>any delayed departure, missed connections,substitutions of accommodations, terminations of service, or
                changes in fares and rates;
            </li>
            <li>any cancellation or double-booking of reservations or tickets beyond the reasonable control of <strong>flightsgyani.com</strong>;
                and
            </li>
            <li>any claim of any nature arising out of or in connection with air or other transportation services,
                products or other features performed (or not) or occurring (or not) in connection with your itinerary.
            </li>
        </ul>


        <p>For avoidance of doubt (and without limiting the foregoing), <strong>flightsgyani.com</strong> does not
            assume any liability whatsoever for cancelled flights, flights that are missed, or flights not connecting
            due to any scheduled changes made by the relevant airline.</p>


        <p class="text-center bold">INDEMNIFICATION</p>

        <p>You agree to protect and indemnify <strong>flightsgyani.com</strong>, its affiliates, partners, joint
            ventures and/or their respective suppliers and any of their respective officers, directors, managers,
            employees and agents from and against any claims, causes of action, demands, recoveries, losses, damages,
            fines, penalties or other costs or expenses of any kind or nature including but not limited to reasonable
            legal and accounting fees, brought by:</p>


        <ul>

            <li>you or on your behalf in excess of the liability described above provided that such limitation of
                liability is permitted by the law of your state of residence;
            </li>

            <li>by third parties as a result of your breach of these Terms Conditions, notices or documents referenced
                on the Site;
            </li>

            <li>your violation of any law or the rights of a third party; or</li>

            <li>your use of the Site.</li>
        </ul>

        <p><br/>
            <!--[if !supportLineBreakNewLine]--><br/>
            <!--[endif]--></p>

        <p class="text-center bold">RELEASE</p>

        <p>If you have a dispute with a travel product or service supplier(s), including but not limited to airlines,
            hotels, cruise lines, railroads, car rental agencies, tour operators and consolidators, vacation packages
            and activities suppliers, traveler assist service providers and insurance providers, you release us, our
            affiliates, partners, joint ventures and their respective officers, directors, managers, agents and
            employees from claims, demands and damages (direct, indirect, incidental, and consequential) of every kind
            and nature, known and unknown, arising out of or in any way connected with such disputes.</p>


        <p class="text-center bold">PRIVACY</p>

        <p>Please review our Privacy Policy, which also governs your visit to this Site to understand our practices. The
            <strong>flightsgyani.com</strong> Privacy Policy will provide a description of how we protect and use your
            personal information. If you object to your information being transferred or used in this way please do not
            use our services.</p>

        <p class="text-center bold">Protecting Your Security</p>

        <p>To ensure that your credit, debit or charge card is not being used without your consent, we may validate your
            name, address and contact number supplied by you during the booking process against appropriate third party
            databases. By accepting these Terms &amp; Conditions you agree and authorize us to carry out such
            verification checks as stated herein. In performing these checks, you acknowledge and concur that such
            personal information you provide to us may be disclosed to a registered Credit Reference Agency which may
            keep a record of such information in whole or in part.Rest assured this verification process is performed
            for the sole purpose to verify and confirm your identity, and that this process does not perform a credit
            check, and your credit rating will not be affected whatsoever. All information provided by you to us is
            securely processed in strict accordance with the Data Protection Act of Nepal.</p>

        <p class="text-center bold">SITE USAGE AND TICKET PURCHASE</p>

        <p>You warrant that you are at least 18 years of age and possess the legal authority to enter into this
            agreement and to use the Site in accordance with all Terms &amp; Conditions herein. If you are using this
            Site and/or making travel reservations or bookings for another person you agree to inform that person(s)
            about the Terms &amp; Conditions that apply to the travel reservations and bookings you have made on their
            behalf, including all rules and restrictions applicable thereto and these Terms &amp; Conditions. You agree
            to be financially responsible for all of your use of the Site (as well as for use of your account by
            others). You are responsible for any bookings and travel reservations made by persons under your direction
            or control. You also warrant that all information supplied by you or on your behalf, or by members of your
            household in using the Site is true, current, complete and accurate. Furthermore you also confirm that the
            traveler is not an unaccompanied minor. Without limitation, any exploratory, speculative, false, or
            fraudulent reservation or any reservation in anticipation of demand is prohibited.</p>

        <p>Whenever you make use of a Site feature that allows you to upload material to the Site, or to make contact
            with other users of the Site, you must comply with applicable laws and the best standards of internet
            courtesy and behavior. You undertake that any such contribution does comply as aforementioned, and you
            irrevocably undertake to fully indemnify us at all times for any breach of that warranty and undertaking.
            Any material you upload to the Site will be considered non-confidential and non-proprietary and we have the
            right to use, copy, store, distribute and disclose to third parties any such material for any purpose. We
            also have the right to disclose your identity to any third party who is claiming that any material posted or
            uploaded by you to the Site constitutes a violation of their intellectual property rights, or of their right
            to privacy. We will not be responsible or liable to any third party for the content or accuracy of any
            materials posted by you or any other user of the Site. We have the right to remove any material or posting
            you make on the Site if, in our opinion, such material does not comply with these Terms &amp;
            Conditions.</p>

        <p class="text-center bold">RESOLUTION OF DISPUTES</p>

        <p class="bold" style="color: red;">PLEASE READ THIS SECTION CAREFULLY. IT AFFECTS YOUR RIGHTS AND WILL HAVE A
            SUBSTANTIAL IMPACT ON HOW CLAIMS YOU AND WE MAY HAVE AGAINST EACH OTHER ARE RESOLVED.</p>

        <p>Customer satisfaction is the foundation of our success. That&#39;s why, if a dispute arises between us, our
            goal is to resolve the dispute quickly in a fair and cost-effective way. Accordingly, we strongly encourage
            you, before taking any other action, to reach out to us by contacting customer service at 9801095029/30/31
            info@<strong>flightsgyani.com</strong> so that we have an opportunity to try to address your concerns.</p>

        <p>Otherwise, you and we agree that we will resolve any dispute, claim or controversy arising out of or relating
            to your use of the Site, these Terms &amp; Conditions, or the breach, termination, enforcement,
            interpretation or validity thereof, or our relationship in connection with the Site or these or previous
            versions of these Terms &amp; Conditions (each, a &quot;Claim&quot;), in accordance with one of the
            subsections of this Resolution of Disputes section below or as otherwise mutually agreed by the parties in
            writing.</p>

        <p><br/>
            <!--[if !supportLineBreakNewLine]--><br/>
            <!--[endif]--></p>

        <p class="text-center bold">GOVERNING LAW; SUBMISSION TO JURISDICTION</p>

        <p>These Terms &amp; Conditions and the rights of the parties hereunder shall be governed by and construed in
            accordance with the laws of the Nepal, exclusive of conflict or choice of law rules. You agree that unless
            otherwise mutually agreed by the parties in writing or as otherwise described in the Mandatory Arbitration
            provision below, any Claims shall be brought in a court located in Butwal,Nepal. Unless otherwise prohibited
            by applicable law, any Claim must be brought within two (1) years from the date on which such Claim arose or
            accrued.</p>

        <p><br/>
            <!--[if !supportLineBreakNewLine]--><br/>
            <!--[endif]--></p>

        <p class="text-center bold">PROHIBITED ACTIVITIES</p>

        <p>You agree that the travel services reservations facilities of the Site shall be used only to make legitimate
            reservations or purchases for you or for another person for whom you are legally authorized to act. You
            understand that overuse or abuse of the travel services reservation facilities of the Site may result in you
            being denied access to such facilities. You may not use this Site for any commercial purpose. You agree you
            will not access, monitor or copy any content or information of this Site using any robot, spider, scraper or
            other automated means or any manual process for any purpose without our written permission. You agree that
            you will not violate the restrictions in any robot exclusion headers on this Site,
            or bypass or circumvent other measures employed to prevent or limit access to this Site. You agree you will
            not you modify, copy, distribute, transmit, display, perform, reproduce, publish, license, create derivative
            works from, transfer, or sell or re-sell any information, content, graphics, software, products, or services
            obtained from or through this Site or call center. You agree you will not use a frame or border environment
            around the Site, or other framing technique to enclose any portion or aspect of the Site, or mirror or
            replicate any portion of the Site, and that you will not sell, offer for sale, transfer, or license any
            portion of the Site in any form to any third parties.</p>

        <p>You agree you will not use any device, software, or routine that interferes, or attempts to interfere, with
            the normal operation of our Site, or take any action that impose an unreasonable load on our equipment. You
            will not disguise the origin of the information you transmit through the Site, whether to navigate the Site,
            make a travel reservation or booking, or post any content.You must not misuse the Site by knowingly
            introducing viruses, trojans, worms, logic bombs or other material which is malicious, offensive, defamatory
            or technologically harmful. You must not attempt to gain unauthorized access to the Site, the server on
            which the Site is stored or any server, computer or database connected to the Site.</p>

        <p>You must not attack the Site via a denial-of-service attack or a distributed denial-of service attack. We
            will not be liable for any loss or damage caused by a distributed denial-of-service attack, viruses or other
            technologically harmful material that may infect your computer equipment, computer programs, data or other
            proprietary material due to your use of the Site or to your downloading of any material posted on it, or on
            any website linked to it.</p>

        <p>We reserve the right to cancel your <strong>flightsgyani.com</strong> account and terminate your use of the
            Site if you violate any of the above prohibitions.</p>

        <p><br/>
            <!--[if !supportLineBreakNewLine]--><br/>
            <!--[endif]--></p>

        <p class="text-center bold">BOOKING PROCESS</p>

        <p>For your convenience, our use of the following terms in these Terms &amp; Conditions shall have the meaning
            below:</p>

        <p>&quot;Service Element&quot; - a singular product or service listed on the Site that can be booked
            independently of any other service. (e.g.: car, hotel, flight).</p>

        <p>&quot;Travel Supplier&quot; - a vendor of one or more Service Elements. (e.g.: hotels, car suppliers,
            airlines). <strong>flightsgyani.com</strong> does not act as principal but makes arrangements with
            third-party vendor Travel Suppliers for Service Elements, all as defined above.</p>

        <p>&quot;Booking&quot; - a negotiation process with the Travel Supplier carried out by you while using this Site
            for the purpose of obtaining one or more Service Elements that may result in a contract with the Travel
            Supplier at the time we receive full payment and accept your offer.</p>

        <p>In order to complete a Booking the following steps are taken to ensure its validity:<br/>
            When we place Service Elements on our Site, we are inviting you to make an offer for their purchase. You do
            not make this offer until you press &quot;Book&quot; on the payment page (entitled &quot;Review Trip Details
            and Book&quot;) of the Site.</p>

        <p>Once you have done so you have made <strong>flightsgyani.com</strong> an offer (which cannot be withdrawn if
            you change your mind) to purchase the relevant Service Element(s) from the relevant Travel Supplier(s) (your
            &quot;Booking&quot;). We are free to accept your offer on behalf of the relevant Travel Supplier or to
            reject it, at our sole discretion.</p>

        <p>The <strong>flightsgyani.com</strong> email confirmation is NOT the contractual acceptance of the Booking,
            but merely an acknowledgement that we have received your offer. We will need to check the availability of
            the relevant Service Element(s).</p>

        <p>If the relevant Service Element is available, your Booking will be processed. The contract pertaining to the
            relevant Booking is formed when payment in full has been received.</p>

        <p>The contract between you and the relevant Travel Supplier will relate only to those Service Elements
            confirmed by email with ticket numbers in case of air or reservation numbers in case of hotels, cars or
            activities.</p>

        <p>The terms of your Booking (such as price, availability and/or dates of travel) are not guaranteed until the
            contract is formed between you and the Travel Supplier and a ticket has been issued and/or a reservation has
            been made and confirmed by the Travel Supplier. Please note that once you have completed the Booking stage
            you can only cancel or change the details (such as names or destinations) of your Booking at our sole
            discretion and in accordance with these Terms &amp; Conditions.</p>

        <p>These Booking processes will apply to any of our individual Service Element&#39;s Terms &amp; Conditions set
            out below. The airline ticket Terms &amp; Conditions, the hotel Terms &amp; Conditions, the car rental Terms
            &amp; Conditions, the attractions and services Terms &amp; Conditions supplement any area not covered by the
            Booking process. We reserve the right to change the Booking process at any time, with changes automatically
            taking effect from the date such changes are posted on the Site.</p>

        <p>At all times throughout your trip a government-issued photo ID is required for security checks at airports,
            hotels and car rental locations and may be required for attractions and other products as deemed necessary
            by the relevant Travel Suppliers.</p>

        <p>In addition to the required government-issued ID as stated above, proof of citizenship (Passport) is required
            for international travel (for most countries outside of the Nepal). Please note that it is your sole
            responsibility to ensure that you meet the passport, visa, and/or health requirements of the countries you
            wish to visit and those that you transit (even if it is for a simple flight change). Many countries require
            that your passport should be valid for a minimum period from the date of arrival into that country. For any
            questions regarding what the applicable minimum period is and any other conditions or passport/visa
            requirements for travel, you should contact the corresponding local consulate of the countries to which you
            are travelling.</p>

        <p>Neither <strong>flightsgyani.com</strong> nor its affiliates accept any responsibility, and you will not be
            entitled to any refunds whatsoever, if you are denied boarding, delayed or deported due to non-fulfillment
            of the above.</p>


        <ul>

            <li>Government entry/exit fees may apply, depending on your destination.</li>

            <li>These are your sole responsibility and will be additional to your Booking charges.</li>

            <li>All travelers on your Booking (if more than one passenger) must travel on the same itinerary. Individual
                passengers cannot &nbsp; &nbsp; &nbsp;be added to, and/or deleted from your Booking.
            </li>
        </ul>


        <p><strong>flightsgyani.com</strong> reserves the right to correct errors in any advertised price and, if
            applicable, give you an option to either cancel the Booking or allow <strong>flightsgyani.com</strong> to
            collect an amount equal to any increase in price from your provided credit or debit card, prior to your
            departure.</p>


        <ul>

            <li>Each Service Element listed in your Booking is provided by the respective Travel Supplier.</li>

            <li>Frequent traveler points and/or miles may or may not be available for any portion of your Booking. You
                must check this with the &nbsp; &nbsp; &nbsp;relevant Travel Supplier.
            </li>
        </ul>


        <p>Once you have made your Booking, you cannot transfer or change the name(s) or destination(s) listed in your
            Booking.</p>

        <p>Your Booking will be fulfilled on the delivery date set out in your ticket information email or, if no
            delivery date is specified, then on the date the ticket is issued, unless there are exceptional
            circumstances.</p>

        <p>The terms of this agreement incorporate by reference the terms of each airline&#39;s contract of carriage.
            Passengers may inspect the full text of the contract of carriage at the each airline&#39;s airport or city
            ticket offices. Passengers have the right, upon request to the airlines, to receive free of charge by mail
            or other delivery service the full text of the contract of carriage. The incorporated terms of the contract
            of carriage may include: (1) Limits on the airline&#39;s liability for personal injury or death of
            passengers, and for loss, damage, or delay of goods and baggage, including fragile or perishable goods; (2)
            Claim restrictions, including time periods within which passengers must file a claim or bring an action
            against the airline for its acts or omissions or those of its agents; (3) Rights of the airline to change
            terms of the contract; (4) Rules about reconfirmation of reservations, check-in times, and refusal to carry;
            (5) Rights of the airline and limitations concerning delay or failure to perform service, including schedule
            changes, substitution of alternate airline or aircraft, and rerouting.</p>

        <p class="text-center bold">Pricing, Taxes/Fees, and Payment</p>

        <p>Our total prices include all taxes and fees applicable to airfare, hotel accommodation, car rentals and
            activities included in your Booking, unless stated otherwise in your ticket information email or in these
            Terms &amp; Conditions. Additional fuel surcharges, security, baggage, seat reservation, hotel incidentals,
            and other applicable service charges may apply which will be charged by the relevant Travel Supplier at time
            of check-in. You are solely responsible for any such additional charges due to the Travel Supplier. If you
            have any questions about such charges, please contact the relevant Travel Supplier directly.</p>

        <p>Prices quoted for Service Element(s) do not include liability insurance, collision damage waiver, personal
            accident insurance, personal effects protection, drop-off charges, gas, child(ren) safety seats, sky racks
            or incidental room charges at the hotel (telephone, movies, energy surcharges and any applicable increases
            in taxes). All such charges must be paid at the car rental pick-up location and/or at the check-in counter
            at the hotel.</p>

        <p>Prices quoted also do not include any additional flight fuel surcharges or other surcharges which may be
            imposed from time to time by the relevant Travel Supplier or authorities, all of which must be paid by
            you.</p>

        <p>Payment must be made in full with a valid credit or debit card at the time of Booking. <strong>flightsgyani.com</strong>
            accepts all major credit or debit cards with a verifiable billing address.</p>

        <p>You hereby authorize <strong>flightsgyani.com</strong> and its authorized third party to process the charge
            to the credit or debit card you provide to us for the total amount of your Booking.</p>

        <p>You may be required by the relevant Travel Supplier(s) to present a valid credit or debit card at the time of
            check-in at the hotel and/or at the pick-up location of the car rental company to provide confirmation of
            authorized card usage and/or to secure any additional charges. The cardholder must be a traveler listed on
            your Booking.</p>

        <p>All offers, prices, and conditions of sale may be subject to:</p>


        <ul>

            <li>change without notice;</li>

            <li>advance purchase, eligibility, seating, or other limitations;</li>

            <li>travel days, dates, minimum or maximum stays, holidays, seasons, blackout dates, stopovers, and/or
                waitlisting restrictions;
            </li>

            <li>reservation validation limitations of up to one year (if any extension permitted, penalties/restrictions
                may apply);
            </li>

            <li>other conditions/restrictions; and</li>

            <li>availability.</li>
        </ul>


        <p>A reservation is not complete until confirmed/ticketed. To protect our customers, we verify with the
            credit/debit card company that the billing address and credit card verification number you provided to us is
            accurate and that your debit/charge will be accepted. Until such information is verified, the fare is
            subject to change. We are not responsible for any transaction that is declined based upon a credit/debit
            card that is declined by the issuing company or a travel provider or if, for any reason, the debit/credit
            card billing address and/or credit card verification number cannot be verified in a timely manner, nor are
            we responsible for any changes in fare or any other charges that may occur during our verification process.
            In the event the fare selected is not available an approval code may have been issued on your credit card.
            If the transaction is not completed the approval code may temporarily credit the amount from your bank
            account.</p>

        <p class="text-center bold">LINKS</p>

        <p>The Site provides links to other websites as a convenience to you or as advertising of other suppliers and
            vendors related or unrelated to travel. We do not endorse any such suppliers and vendors nor are we
            responsible for the contents of other websites or their privacy policy or other practices. If you decide to
            access other websites you do so at your own risk and it is your sole responsibility to read their Terms
            &amp; Conditions and ensure that whatever links you select or software you download (whether from this Site
            or other websites) is free of such items as viruses, worms, trojan horses, defects and other items of a
            destructive nature such as malware.</p>


        <p class="text-center bold">OUR FEES AND EXCEPTIONS</p>

        <p>In addition to each Travel Supplier&#39;s cost and fees, <strong>flightsgyani.com</strong> may charge a
            service fee as described below. All <strong>flightsgyani.com</strong> fees are charged on a per-passenger,
            per-ticket basis and are generally non-refundable.</p>


        <p>1. OUR BOOKING FEES</p>


        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Our Fees</th>
                <th>May Apply To</th>
                <th>Code</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Online Air Transaction Service Fees
                    On most airfares a service fee up to NPR 300 is charged on a per-passenger, &nbsp; per-ticket basis.
                    **
                </td>
                <td>Nepal Domestic and International</td>
                <td>Fees &loz;</td>
                <td>Rs.0 to Rs. 300</td>
            </tr>
            <tr>
                <td>Online Hotel Transaction Service Fees(per night, per room)</td>
                <td>All Hotels</td>
                <td>Fees &loz;</td>
                <td>up to Rs.100</td>
            </tr>
            <tr>
                <td>Online Car Rental Transaction &nbsp; Service Fees (per rental)</td>
                <td>All Car Rentals</td>
                <td>Fees &loz;</td>
                <td>up to Rs300</td>
            </tr>
            <tr>
                <td colspan="4">Service fees will be converted in &nbsp; your local currency on the payment page.
                </td>
            </tr>
            </tbody>
        </table>


        <ul>

            <li>** Passenger types = Adult(s), child(ren), senior, infant(s), student, military.</li>

            <li>&Dagger; All transaction service fees are non-refundable and are subject to change without notice.</li>

            <li>Government imposed taxes and fees are subject to change.</li>

            <li>Business and First Class Airfares - Service fees are up to Rs 1000 per passenger on all passenger type
                tickets.
            </li>

            <li>Multi-city trips - Service fees are up to Rs 500 per passenger on all passenger type tickets.</li>

            <li>Multi airline trips / Cities with high fraud rates - Service fees are up to Rs 500 per passenger on all
                passenger type tickets.
            </li>

            <li>Our service fees on certain airlines may be up to Rs 800 per passenger</li>
        </ul>


        <p class="bold" style="color: red;">Important Note: All service fees are subject to change without notice. you
            will be charged the final total price as quoted regardless of any change or variance in the service fees.
            please review the total final price carefully.</p>

        <p>All Airline Refunds/Future Credits are subject to each airline fare rules, policies and procedures<br/>
            Service fees will be converted in your local currency on the payment page.<br/>
            Passenger types = Adult(s), child(ren), senior, infant(s), student, military.<br/>
            Service fees on all changes, refunds, cancellations and future credits will be charged on a per passenger,
            per ticket basis.</p>

        <p>&Dagger; Like our transaction service fees (booking fees), all post-ticketing service fees are non-refundable
            and are subject to change without notice. Our fees are in addition to any airline and/or other supplier
            imposed fees and charges.</p>


        <p>Government imposed taxes and fees are subject to change. You will only be charged the final total amount
            displayed or quoted by our agent.</p>

        <ul>

            <li>1 Most of our airline tickets are non-refundable. Only available if our Travel Suppliers&#39; fare rules
                allow cancellation and refunds, and we have accepted your request for a refund, you are not a &quot;no
                show&quot;
                (most &quot;no show&quot; bookings are in-eligible for any waiver from suppliers for refund processing),
                and if we are able to secure waivers from suppliers to process this requested cancellation and refund.
            </li>

            <li>2 Most of our airline tickets are non-refundable. Airline Refunds/Future credits are subject to airline
                fare rules, policies and procedures.
            </li>

            <li>3 Special Services - All Special Services are on a request basis ONLY and are subject to each airline&#39;s
                review and approval process along with their fare rules, policies and procedures.
                Special Service Fees will be charged upon the provision of the service(s) and will only be refunded if
                the request is denied by the airline.
            </li>
        </ul>


        <p><strong>Name Misspelling</strong>&nbsp;- Passengers name on their airline ticket does not match their
            passport or other universally accepted government ID</p>

        <p><strong>Visa/Passport</strong>&nbsp;- A Visa/Passport decline letter is normally required in order to process
            a request</p>

        <p><strong>Baggage</strong>&nbsp;- please retain all receipts and baggage tags</p>

        <p><strong>No- Show</strong>&nbsp;- Documentation advising why you were unable to make your scheduled departure
            will be required</p>

        <p><strong>Denied Boarding</strong>&nbsp;- Documentation as why you were denied boarding of your scheduled
            departure will be required</p>

        <p><strong>Duplicate Tickets</strong>&nbsp;- Copies of all tickets, reflecting exact same itineraries booked
            with us will be required in order to process a refund request</p>


        <p class="text-center bold">CHANGES TO FLIGHTS ALREADY PURCHASED</p>

        <p>Any and all changes made to the itinerary are restricted and are subject to airline fare rules, whichever is
            more restrictive; most of our tickets,hotels,cars,packages and cruises do not allow any date or name changes
            after the booking is completed. <strong>flightsgyani.com</strong> does not guarantee, and shall not be
            responsible for, any bookings or reservations made or confirmed to you in the event that the original
            itinerary has been changed by the supplier pursuant to customer&#39;s request or supplier&#39;s schedule
            changes.</p>

        <p class="text-center bold">CANCEL AND EXCHANGE</p>

        <p>Most of our airline tickets are 100% non-refundable. In certain cases where the airline may allow
            cancellations, a credit may be valid towards a future ticket purchase by the same traveler on the same
            airline. Usually the credit issued by the airline supplier has a specific expiration date, after which it
            cannot be used. We encourage you to discuss additional restrictions attached to your credit with a customer
            service agent. All such bookings where the cancellation may be permitted must be cancelled prior to the
            scheduled departure time of the first flight segment by calling our customer service center. We do not
            guarantee any cancellation. When you are ready to make your new booking and wish to use your airline credit,
            you will be required to the pay fare difference (if any), applicable airline penalties and any applicable
            <strong>flightsgyani.com</strong> post-ticketing fees. All such changes are governed by each airline&#39;s
            fare rules, policies and procedures, which are not under our control.</p>

        <p>No additional representation is made for our exchange fees except that an agent will assist you in locating
            your desired new flights and attempt to re-book the new flights based on availability and other factors.</p>

        <p class="text-center bold">MULTIPLE AIRLINE ITINERARIES</p>

        <p>If your itinerary includes flights operated by more than one airline, please read carefully each such airline&#39;s
            terms and conditions, which can be found on each such airline&#39;s website. Each such airline will have its
            own restrictions, rules and fees. If one of these flights is affected by an airline change (e.g.
            cancellation or rescheduling) that causes a Customer to make changes to the other flight, the Customer may
            be responsible for any fees or ticket cost incurred for making changes to the unaffected flight. Such
            airlines may charge their own fees for changes, refunds, or if exchanges are requested. You are responsible
            for complying with each airline&#39;s terms and conditions, which may differ (for example, check-in times
            and limits on baggage size/weight). It is advisable you print your outbound and return portions of your
            e-ticket confirmation for all flights prior to travelling. You may be asked for proof of your return ticket
            at check-in.</p>

        <p class="text-center bold">CANCEL AND REFUND</p>

        <p>Most of our airline tickets, hotels, pre-paid car rentals, vacation packages and service fees are
            non-refundable after 24 hours of booking. Trip protection insurance is refundable within 10 days of purchase
            if travel has not commenced and you have called our customer service center to cancel. All cancellations
            must be done over the phone only. We can accept refund requests only if the following conditions have been
            met:</p>

        <ul>

            <li>you have applied for a cancellation and refund with us and if the fare rules provide for cancellation
                and refunds;
            </li>

            <li>you are not a &quot;no show&quot; (most &quot;no show&quot; bookings are in-eligible for any waiver from
                suppliers for refund processing); and
            </li>

            <li>we are able to secure waivers from suppliers to process this requested cancellation and refund.</li>
        </ul>

        <p>We are unable to provide a specific time line for how long it may take for this requested refund to be
            processed. All refund requests are processed in a sequential format. Once you have provided our customer
            service agent with your cancellation request, we will then send you an email notification that your request
            has been received. This notification does not automatically qualify you for a refund. This only provides you
            with an acknowledgement of your request
            and provides you with a tracking number. Upon receipt of your request we will work with the suppliers such
            as airlines, hotels, car-rental companies to generate a waiver based on airline and other supplier rules and
            notify you of the supplier decision. Our services fees associated with the original travel reservation or
            booking are not refundable. Please note that we are dependent on the suppliers for receiving the requested
            refunds. Once the refund has been approved by the supplier it may take additional time for this to appear on
            your credit card statement. Generally, all suppliers will charge a penalty for refund. This entire process
            may take 60-90 days from receipt of your request to receiving credit on your statement. Apart from the
            airlines and other suppliers refund penalties, <strong>flightsgyani.com</strong> will charge a
            post-ticketing services fee, as applicable. All refund fees are charged on per-passenger, per-ticket basis.
            These fees will only be assessed if a refund has been authorized by the supplier or a waiver has been
            received and when the airline/supplier rules permit such refunds. If such refund is not processed by the
            supplier, we will refund you our post-ticketing service fees applicable to your agent assisted refund
            request , but not our booking fees for the original travel reservation or booking.</p>

        <p>If you have any questions regarding privacy, please read our privacy policy.</p>


        <p class="text-center bold">FARE CHANGES AND POST PAYMENT PRICE GUARANTEE</p>

        <ul>

            <li>Prior to your form of payment being processed and accepted successfully, if there is a change in the
                price of air fare or any other change, you may be notified of this change and only upon such
                notification you have the right to either accept or decline this transaction. If you elect to decline
                this transaction, you will not be charged.
            </li>

            <li>Our Post Payment Price Guarantee: Upon successful acceptance and processing of your payment
                (credit/debit card), we guarantee that we will honor the total final quoted price of the airline tickets
                regardless of any changes or fluctuation in the price of air fare.
            </li>
        </ul>


        <p class="text-center bold">TICKET DELIVERY</p>

        <p>Most tickets are electronic (e-Tickets), however with certain itineraries where an e-Ticket is not available
            a paper ticket will be issued. Please check the shipping charges before confirming the booking. If an
            e-Ticket could not be issued for a particular reservation or if a delivery was being made of another product
            or service,
            <strong>flightsgyani.com</strong> will send the paper ticket, product or service through a secure mode of
            delivery (a reputable carrier company) and the applicable shipping charges will be debited to the credit
            holder&#39;s account as per rates published on the Site. These shipping charges are displayed before you
            make the booking and you may select not to purchase the tickets to avoid shipping charges. <strong>flightsgyani.com</strong>
            does not assume any responsibility for the fault of the delivery company. We will attempt to redeliver but
            do not provide any guarantees for redelivery on time. If you provide an incorrect address, then you may have
            to pay excess fees to the delivery company for alteration of the address. You will be billed to the credit
            card used for payment. If an e-Ticket is generated the ticket information will be available on the Site.</p>

        <p class="text-center bold">CREDIT/DEBIT CARD DECLINES</p>

        <p>If your credit card declines at the time of processing your transaction, we will make all efforts to notify
            you by email within 72 hours. The transaction will not be processed if your credit card has been declined.
            The fare and any other booking details are not guaranteed. If there is a fare change you have a right to
            cancel the booking at no cost to you. There will be no service fees charged for this.</p>

        <p class="text-center bold">SEATS, MEALS, FREQUENT FLYER AND OTHER SPECIAL REQUESTS</p>

        <p>Please note that your seats, meals, frequent flyer and other special requests are requests only. Any service
            fees that we charge for making such special requests on your behalf are non-refundable for services rendered
            and do not guarantee any particular result. We do not guarantee you will be assigned the seat(s) you have
            requested. We also do not guarantee that your meal(s), frequent flyer and other special requests will be
            honored by the airline. It is therefore recommended you contact your airline directly to confirm these
            requests prior to your scheduled departure date.</p>

        <p class="text-center bold">BAGGAGE POLICY AND FEES</p>

        <p>If you have excess baggage, you will have to pay any excess baggage fee assessed by each airline. Most
            airlines now charge baggage fees even for the first bag checked-in; we recommend traveling light to reduce
            these costs. To find the baggage fees for each airline, please visit our Baggage Fees option in each booking
            you made. We make an effort to keep the baggage fees table updated but we recommend you contact the airline
            directly for the latest fees on check baggage and policy as it relates to baggage.</p>

        <p class="text-center bold">BAGGAGE POLICY ON CONNECTING FLIGHTS</p>

        <p>When there are two or more airlines involved for connecting flights, you may have to reclaim your bags at the
            connecting airport and check-in again to continue your journey. In these cases, if you have excess baggage,
            you will have to pay any excess baggage fee assessed by each airline. Most airlines now charge baggage fees
            even for the first bag checked-in, we recommend traveling light to reduce these costs. To locate the fees on
            baggage check-in by airlines, please visit Baggage Fees options in each booking you make.</p>

        <p class="text-center bold">AIRLINE OPTIONAL SERVICES AND PRODUCTS</p>

        <p>From time to time and depending on the airline(s) operating your flight(s), we may provide you with the
            option to request through us Airline optional services and products in connection with your ticket(s), which
            may include, without limitation pre-reserved seat assignments and checked baggage.</p>

        <p>Such optional services and products will be provided to you by the airline(s) and their purchase cost shall
            be in addition to the ticket cost and subject to the each airline&#39;s availability and terms of use. Any
            service fees that we charge for requesting such optional services and products on your behalf are
            non-refundable for services rendered and do not guarantee such requests will be honored by the airline(s).
            We strongly encourage you to check the restrictions the airline(s) operating your flight(s) might have in
            connection with the optional products and services you request through us.</p>

        <p>You acknowledge that we are acting as a marketing agent with regard to any airline optional services and
            products. You agree that our entire aggregate liability to you arising out of or in connection with your
            request of any optional services and products through us is limited to the purchase cost of such services or
            products. We strongly encourage you to contact the operating carrier to resolve any issues concerning the
            use and availability of any such optional services and products.</p>

        <p class="text-center bold">AIRLINES SCHEDULE CHANGES/FLIGHT CANCELLATIONS </p>
        <p class="text-center">(Airline Policy on Schedule Changes)</p>

        <p>All Airlines have differing rules and policies regarding schedule changes, which are beyond our control.</p>

        <p>Due to the operational needs of each airline, changes are often made to the flights that they are currently
            operating. Often these changes are a prediction of travel needs for a future dates but can also reflect same
            day changes. Types of changes could be: flight number changes, time changes, routing, date changes and or
            cancellations. Cancellations include when an airline has stopped or temporarily canceled service to certain
            cities, or stopped service on certain days of the week.</p>


        <p class="text-center bold">Cancellations</p>
        <p>Reasons for cancellations or schedule changes may include:</p>

        <ul>
            <li>peak or high travel seasons;</li>
            <li>low travel season;</li>
            <li>airport terminal or gate changes;</li>
            <li>fuel prices;</li>
            <li>civil unrest;</li>
            <li>natural disasters - volcano, earthquakes, hurricanes, etc.; and</li>
            <li>Bankruptcy.</li>
        </ul>


        <p><strong>flightsgyani.com</strong> does not assume any liability whatsoever for cancelled flights, flights
            that are missed, or flights not connecting due to any scheduled changes made by the airlines.</p>

        <p class="text-center bold">Our Policy on Schedule Changes</p>

        <p>We make every attempt to notify the customer of any schedule changes. It is always best to contact the
            airline to reconfirm you flights within 72 hours of departure.</p>

        <p class="text-center bold">Prior to Departure</p>

        <p>If an airline has a change to any of its flights within a 4 hour period of your original flight times, we
            will notify you of such change by email. We will attempt to contact you via other information provided by
            you, but; if we are unable to get in touch with you, our email will serve as final notice. For all such
            changes within a 4 hour period, tickets will remain non-refundable. Certain ticket types may be
            non-refundable even when the schedule change is over 4 hours. <strong>flightsgyani.com</strong> does not
            assume any liability whatsoever for cancelled flights, flights that are missed, or flights not connecting
            due to any scheduled changes made by the airlines.</p>

        <p class="text-center bold">Date of Departure</p>

        <p>If you have already arrived at the airport you will need to speak with an agent at the airline counter.
            During severe weather, options may be limited and although it is sunny where you are there may be bad
            weather at your destination or connection cities. You should always check the airlines website and weather
            channels for airport updates. It is always best to contact the airline directly, if it is the date of
            departure.</p>

        <p class="text-center bold">Customers Obligations:</p>

        <p>It is always important for the customer to reconfirm their flights with the airlines 24 to 72 hours prior to
            departure, especially if they are already traveling. You should periodically check emails for updates
            regarding flight schedules and respond in a timely manner.</p>

        <p class="text-center bold">Customer Notification</p>

        <p>Depending on departure date and when we receive the change from the airline we will attempt to send at least
            3 emails and call at least 1 time. If you do not contact either <strong>flightsgyani.com</strong> or the
            airline prior to your departure you may: miss your flights, lose the value of your tickets and possibly have
            your travel postponed by 1 or 2 days or even a few weeks before the airline can accommodate you.</p>

        <p class="text-center bold">Services Provided</p>

        <p>Once you have contacted <strong>flightsgyani.com</strong> we will contact the airline on your behalf and try
            to come to a resolution. In some cases the only resolution may result in cancellation of the flight and
            refund.</p>

        <p>If a customer does not fulfill their obligation, they may miss their flight or lose the value of their
            reservation, and other options may not be available.</p>

        <p>We will make every attempt to get the airlines in question to re-protect the customer. It ultimately depends
            on the airline or airlines involved. If the airline is unable to re - protect the customer we will request a
            refund.</p>

        <p>In the event that a flight is cancelled, <strong>flightsgyani.com</strong> will attempt to contact the
            airline, find other flight options and/or discuss refund options.</p>

        <p class="text-center bold">OVERBOOKING OF FLIGHTS</p>

        <p>Airline flights may be overbooked, and there is a slight chance that a seat will not be available on a flight
            for which a person has a confirmed reservation. Each airline has its own rules for dealing with such
            scenarios, which are contained in the airline&rsquo;s contract of carriage. Check with the airline or call
            us for details.</p>

        <p class="text-center bold">UNACCOMPANIED MINOR</p>

        <p>Tickets will not be sold directly to unaccompanied minors age 18 and under. Each airline sets its own
            policies and regulations for child(ren) traveling without adult(s) supervision. Please check with the
            airline directly for minor age requirements, as the following items may change:</p>

        <ul>

            <li>Some airlines may not allow unaccompanied minors to travel without an adult.</li>

            <li>Some airlines will only allow unaccompanied minors to travel on non-stop flights.</li>

            <li>Many airlines may require additional fees to be paid at check-in.</li>
        </ul>

        <p>You must call the airline to verify rules and restrictions for unaccompanied minor(s) traveling alone.</p>


        <p class="text-center bold">VISA AND ENTRY REQUIREMENTS</p>

        <p>All customers are advised to verify travel documents (transit visa/entry visa) for the country through which
            they are transiting and/or entering. Reliable information regarding international travel can be found from
            the consulate/embassy of the country(s) you are visiting or transiting through.
            <strong>flightsgyani.com</strong> will not be responsible if proper travel documents are not available and
            you are denied entry or transit into a Country.</p>

        <p>Your transaction with <strong>flightsgyani.com</strong> does not guarantee entrance to the country of
            destination. Traveler understands that <strong>flightsgyani.com</strong> accepts no responsibility for
            determining passenger&#39;s eligibility to enter or transit through any specific country. Information, if
            any, given by <strong>flightsgyani.com</strong>&#39;s employees must be verified with government
            authorities. Such information does not imply responsibility on <strong>flightsgyani.com</strong>&#39;s
            behalf.</p>

        <p class="text-center bold">GENERAL RESTRICTIONS</p>

        <p>All flights should be confirmed with the airline directly as they may have last minute schedule changes. You
            must re-confirm at least 24 hours prior to departure for domestic flights and 72 hours for flights of
            international destinations.</p>

        <p>In most cases, upgrades and standbys will not be permitted. Upgrades/standby are strictly the
            responsibilities of the respective airlines.</p>

        <p>Many of our discounted tickets do not allow for frequent flyer mileage accrual.</p>

        <p>All seat requests will be forwarded to the airlines. Please be advised that not all seat requests are
            guaranteed. If you want to receive immediate confirmation on your seat or if you have any special
            requirement such as &quot;stretcher assistance&quot; or &quot;wheelchair&quot;, please contact the airline
            directly.</p>

        <p>We reserve the right to cancel requests for travel to destinations that have been embargoed by the Nepal
            government.</p>


        <p class="text-center bold">HUMAN ERROR</p>

        <p>If any of our agents make a mistake in the booking process we shall make reasonable attempts to rectify these
            errors at the time of occurrence. <strong>flightsgyani.com</strong> stands committed to providing
            compensation up to a maximum of the entire service fees that <strong>flightsgyani.com</strong> has collected
            for that booking. You must notify us of errors within 24 hours of receiving your itinerary. Beyond this 24
            hour period, <strong>flightsgyani.com</strong> will not be responsible for these errors.</p>

        <p class="text-center bold">ITINERARY RE-CONFIRMATION</p>

        <p>It is the responsibility of the traveler who has booked with us online or has made the booking directly with
            a customer service agent to review and reconfirm names, dates, flight numbers, airlines and routing
            including all airport changes. If you discover any discrepancy in your itinerary, you are requested to
            immediately contact a <strong>flightsgyani.com</strong> customer service agent within 3 hours from the time
            the booking was completed.</p>

        <p>If you fail to contact us by phone within 3 hours of completing the booking, we shall consider the booking
            you have made to be acceptable to you and we do not assume any liability thereafter for any discrepancy in
            your booking.</p>

        <p>You are requested to review and save the itinerary.</p>

        <p class="text-center bold">HAZARDOUS MATERIALS</p>

        <p>Federal law forbids the carriage of hazardous materials aboard aircraft in your luggage or on your person. A
            violation can result in five years of imprisonment and penalties. Hazardous materials include explosives,
            compressed gases, flammable liquids and solids, oxidizers, poisons, corrosives and radioactive materials.
            Examples: Paints, lighter fluid, fireworks, tear gases, oxygen bottles, and radio-pharmaceuticals. There are
            special exceptions for small quantities (up to 70 ounces total) of medicinal and toilet articles carried in
            your luggage and certain smoking materials carried on your person. For further information contact your
            airline representative.</p>

        <p class="text-center bold">DISINSECTION</p>

        <p>Some countries may require aircraft operating international flights to be treated with insecticides.</p>

        <p class="text-center bold">HOTEL RESERVATIONS RULES AND REGULATIONS</p>

        <p>Photos of the hotel and information provided regarding the service, amenities, products, etc. have been
            provided to us by the supplier. <strong>flightsgyani.com</strong> accepts no responsibility for any changes
            that the supplier has not updated.</p>

        <p>Specific features such as bedding type or non-smoking rooms are simply a request and not guaranteed unless
            otherwise specified by the hotel. While most hotels will strive to honor your requests, neither <strong>flightsgyani.com</strong>
            nor the hotel will guarantee that your request will be honored.</p>

        <p>Some rates have special requirements such as Corporate, Government (including Military), AAA, or AARP
            membership. These rates will require you to present identification at the time of check-in to prove that you&#39;re
            eligible for those special rates. Hotel properties are not obligated to honor these rates if you do not
            qualify or if you don&#39;t have identification confirming your eligibility.</p>

        <p>No refunds will be issued for unused room nights due to early departures.</p>

        <p>Some hotels offer an Airport Shuttle as an extra service. You should always contact the hotel prior to
            check-in to find out availability and pricing.</p>

        <p>Booking Bonus&#39; that are offered by the hotels, such as free breakfast, tours, etc. are all subject to
            change and availability and are controlled by the hotel directly.</p>

        <p class="text-center bold">Pet Policies</p>

        <p>It is very important that you confirm directly with the property that they do, indeed, accept pets. <strong>flightsgyani.com</strong>
            accepts no responsibility for an individual property&#39;s pet policy. You must call the hotel directly to
            confirm pet policies, including fees and pet restrictions on breeds and size.</p>

        <p class="text-center bold">Pre-Paid Reservations</p>

        <p>Prepaid Reservations are charged to your credit card at the time of booking. This charge includes Full Base
            Amount (room only) of the reservation. Resort fees, energy surcharges and cleaning fees, may be charged on a
            daily basis. They also will collect for incidentals such as meals, movies, games, wet bar, parking, and
            phone calls. Rates are only guaranteed at the time of booking.</p>

        <p class="text-center bold">Pre-Paid Booking Vouchers</p>

        <p>Some hotels will require a voucher at check-in. <strong>flightsgyani.com</strong> will send the voucher to
            the email address supplied to us when your booking was made. It is always recommended you have a copy of
            your email confirmation with you at check-in.</p>

        <p class="text-center bold">Book Now, Pay Later Bookings</p>

        <p>Book Now, Pay Later Reservations use your credit card to hold your reservation until you arrive for check-in.
            <strong>flightsgyani.com</strong> strongly recommends that you confirm Book Now, Pay Later reservations
            directly with the hotel, no sooner than 24 hours prior to check-in. On some non-prepaid hotels, hotel
            companies require a deposit up to the full amount of the stay. These rates are usually non-refundable, with
            no modifications allowed.</p>

        <p class="text-center bold">Meal Plans</p>

        <p>Meal Plan are the sort of dining arrangements that you have selected for your hotel stay. For example you may
            have selected a hotel which cooks all your meals for you and which are included in the price. Or, you may
            have selected an apartment with cooking facilities, which means you arrange your own meals. Meal Plan
            meanings and abbreviations are as follows:</p>

        <ul>

            <li>Room Only (RO) means that no meals will be included in the price you have paid for your
                accommodation/vacation package.
            </li>

            <li>Self-Catering (SC) means that no meals are included in the cost of your accommodation/vacation package,
                but you will be provided with catering facilities in your accommodation to cook light meals.
            </li>

            <li>Bed and Breakfast (BB) means that breakfast is included in the price you have paid for your
                accommodation/vacation package.
            </li>

            <li>Half Board (HB) means that your breakfast and evening meal is included in the price you have paid for
                your accommodation/vacation package. In some cases you can choose to receive lunch instead of breakfast
                - the hotel will confirm this upon arrival.
            </li>

            <li>Full Board (FB) means that breakfast, lunch and evening meals are included in the price you have paid
                for your accommodation/vacation package.
            </li>

            <li>All-Inclusive (AI) means all meals and locally produced drinks are included (until midnight, when a cash
                bar system may operate.This may vary depending on the accommodation). You may also be entitled to
                entertainment and non-motorized water sports laid on by your hotel.
            </li>
        </ul>


        <p>Photos of the hotel and information provided regarding the service, amenities, products, etc. have been
            provided to us by the supplier. <strong>flightsgyani.com</strong> accepts NO RESPONSIBILITY for any changes
            that the supplier has not updated.</p>

        <p>Specific features such as bedding type or non-smoking rooms are simply a request and not guaranteed unless
            otherwise specified by the hotel. While most hotels will strive to honor your requests, neither <strong>flightsgyani.com</strong>
            nor the hotel will guarantee that your request will be honored.</p>

        <p>Some rates have special requirements such as Corporate, Government (including Military), AAA, or AARP
            membership. These rates will require you to present identification at the time of check-in to prove that you&#39;re
            eligible for those special rates. Hotel properties are NOT obligated to honor these rates if you do not
            qualify or if you don&#39;t have identification confirming your eligibility.</p>

        <p>Pet Policies - It is very important that you confirm directly with the property that they do, indeed, accept
            pets. <strong>flightsgyani.com</strong> accepts NO RESPONSIBILITY for an individual property&#39;s pet
            policy. You must call the hotel directly to confirm pet policies, including fees and pet restrictions on
            breeds and size.</p>

        <p>Some hotels offer an Airport Shuttle as an extra service. You should always contact the hotel prior to
            check-in to find out availability and pricing.</p>

        <p>Booking Bonus&#39; that are offered by the hotels, such as free breakfast, tours, etc. are all subject to
            change and availability and are controlled by the hotel directly.</p>

        <p class="text-center bold">Hotel Changes, Cancellations and Refunds</p>

        <p>Any changes or cancellations should be requested by calling customer service.</p>

        <p class="text-center bold">No-Show Policy</p>

        <p>A No-Show is when you fail to show up to check-in for your reservation without prior notification. If you are
            not going to check in for your reservation you will need to contact the hotel directly. Depending on the
            hotel restrictions you may be charged penalties or lose the entire pre-paid or deposit amount of you
            booking.</p>

        <p class="text-center bold">Hotel Confirmation</p>

        <p>Hotels may take up to 24 hours to return a confirmation number. The process starts when you book the hotel on
            our Site. We will send you an email stating that your reservation is confirmed. This is to let you know that
            we have received your request. If you do not receive any email communication from
            <strong>flightsgyani.com</strong>, please email info@<strong>flightsgyani.com</strong>and include the
            confirmation number and a contact phone number. We suggest you to reconfirm your hotel reservation 24 hours
            prior to check in.</p>

        <p>In many cases, the hotel will not receive the actual guest name until 72 hours prior to arrival. Your
            reservation is secured and guaranteed once you have received the final confirmation email and or voucher. We
            recommend you contact the property within three (3) days of your scheduled arrival to confirm your
            details.</p>

        <p class="text-center bold">All About Changes, Cancellations and Refunds</p>

        <p>Any changes or cancellations should be requested by calling customer service.</p>

        <p>We understand that sometimes plans change. Listed below are additional cancellation and change policies. Some
            policies may vary by property:</p>

        <ul>

            <li>For high-demand special events (i.e.: the Super Bowl, Olympics, New Year&#39;s Eve in Times Square) or
                peak seasonal dates many hotels may change the cancellation policies of the booking.
            </li>

            <li>Cancellations or modifications to the reservation may be subject to <strong>flightsgyani.com</strong>
                cancellation fees in addition to fees charged by the property.
            </li>

            <li>Changes to dates, reduction in rooms or any other amendments are subject to fees based on the hotel&#39;s
                policy.
            </li>

            <li>No credits can be issued for unused room nights due to early departures.</li>

            <li>Stay extensions require a new reservation. Original room rate is not guaranteed.</li>

            <li>Refunds for early departures, no-shows or cancellations are at the sole discretion of <strong>flightsgyani.com</strong>
                and <strong>flightsgyani.com</strong>&#39;s hotel suppliers.
            </li>

            <li>We reserve the right to be indemnified by you in full against all loss, costs, damages, charges and
                expenses incurred by us as a result of any cancellation for any reason.
            </li>

            <li>You must call <strong>flightsgyani.com</strong> if you have any issues during check-in or check-out.
                Many issues may be resolved by a simple phone call.
            </li>
        </ul>


        <p class="text-center bold">Payment, Taxes and Fees</p>

        <p>In connection with facilitating your hotel transaction, the charge to your debit or credit card will include
            a charge for taxes and fees. This charge includes an estimated amount to recover the amount we pay to the
            hotel in connection with your reservation for taxes owed by the hotel including, without limitation, sales
            and use tax, occupancy tax, room tax, excise tax, value added tax and/or other similar taxes. In certain
            locations, the tax amount may also include government imposed service fees or other fees not paid directly
            to the taxing authorities but required by law to be collected by the hotel. The amount paid to the hotel in
            connection with your reservation for taxes may vary from the amount we estimate and include in the charge to
            you. The balance of the charge for taxes and fees is a fee we retain as part of the compensation for our
            services. The charge for taxes and fees varies based on a number of factors including, without limitation,
            the amount we pay the hotel and the location of the hotel where you will be staying, and will include profit
            that we retain.</p>

        <p>For new reservations <strong>flightsgyani.com</strong> will charge booking service fees - up to Rs 300 per
            night, per room.</p>

        <p>For changes/cancellations/refunds of hotel reservation, <strong>flightsgyani.com</strong> will charge a
            service fee Rs 150 per room per night in addition to any supplier penalty fees.</p>

        <p>Except as described below, we are not the vendor collecting and remitting taxes to the applicable taxing
            authorities. Our hotel suppliers, as vendors, include all applicable taxes in the amount billed to us and we
            pay over such amounts directly to the vendors. We are not a co-vendor associated with the vendor with whom
            we book or reserve your travel arrangements. Taxability and the appropriate tax rate and the type of
            applicable taxes vary greatly by location.</p>

        <p>For transactions involving hotels located within certain jurisdictions, the charge to your debit or credit
            card for taxes and fees includes a payment of tax that we are required to collect and remit to the
            jurisdiction for tax owed on amounts we retain as compensation for our services.</p>

        <p>Currency conversions are based on approximate exchange rates at the time of booking and should be used for an
            approximate guide only. These rates are approximate base room charges. Individual hotels collect payment for
            per night room tax, resort fees, and cleaning fees, which may be accessed on a daily basis. They also will
            collect for incidentals such as meals, movies, games, wet bar, parking, and phone calls.</p>

        <p class="text-center bold">VACATION PACKAGE RULES &amp; REGULATIONS</p>

        <p>The Vacation Package Terms &amp; Conditions below within these <strong>flightsgyani.com</strong> Terms &amp;
            Conditions supersede any individual product&#39;s Terms &amp; Conditions. The Airline Ticket Terms &amp;
            Conditions, the Hotel Terms &amp; Conditions, the Car Rental Terms &amp; Conditions, and the Attractions and
            Services Terms &amp; Conditions supplement any area not covered by the Vacation Package Terms &amp;
            Conditions. <strong>flightsgyani.com</strong> reserves the right to modify the
            <strong>flightsgyani.com</strong> Vacation Package Terms &amp; Conditions at any time without notice. In the
            event that the <strong>flightsgyani.com</strong> Vacation Package Terms &amp; Conditions change, the
            modified terms will go into effect on the date when posted on this Site. The amended Terms &amp; Conditions,
            including but not limited to, change and cancellation policies as shown below shall take precedence over any
            previously published and conflicting applicable policies and Terms &amp; Conditions to any individual travel
            product included in the Vacation Package.</p>

        <p>All prices are displayed in Nepalese Rupees (NPR).</p>

        <p>All vacation packages are non- refundable and non-transferrable.</p>

        <p>Your credit card will be charged for the full amount of your <strong>flightsgyani.com</strong> vacation
            package at the time of booking. No portion of the vacation package is guaranteed (such as price,
            availability and/or dates of travel) until the full payment of the entire Vacation Package is received.</p>

        <p class="text-center bold">Documents</p>

        <p>Electronic confirmation and documentation will be sent to the email address on record unless otherwise
            stated.</p>

        <p class="text-center bold">SUBMISSIONS, FEEDBACK, REVIEWS AND BLOG COMMENTS</p>

        <p>We welcome you as a <strong>flightsgyani.com</strong> account member and we welcome your comments, submitted
            reviews of our services and the travel products and services of suppliers and vendors. <strong>flightsgyani.com</strong>
            shall have the right (but not the obligation) to, monitor and review your Submissions (defined below) and
            any other information transmitted or received through our Site. We reserve the right to censor, edit, remove
            or prohibit the transmission or receipt of any information that we deem inappropriate or in violation of
            these Terms &amp; Conditions. Any and all submissions, whether in text or graphical format to this Site by
            opening a <strong>flightsgyani.com</strong> account, any e-mail, postings on this Site or otherwise (such as
            blogs and Facebook&reg;), including any hotel reviews, questions, comments, suggestions, ideas or the like
            contained in any submissions (collectively, &quot;Submissions&quot;), you make includes an explicit consent
            to use such Submissions, and you hereby grant <strong>flightsgyani.com</strong>
            and its affiliates and the affiliated, co-branded and/or linked website partners through whom we provide our
            travel products and services: a worldwide, nonexclusive, royalty-free, perpetual, transferable, irrevocable
            and fully sublicensable right to (a) use, reproduce, modify, adapt, translate, distribute, publish, create
            derivative works from and publicly display and perform such Submissions throughout the world in any media,
            now known or hereafter devised; and (b) use the name, any likeness and all graphics that you submit in
            connection with such Submission. You acknowledge that we may choose to provide attribution of your comments
            or reviews (for example, listing your name and hometown on a hotel review that you submit) at our
            discretion, and that such submissions may be shared with our suppliers. You further grant us the right to
            pursue at law any person or entity that violates your or our rights in the Submissions by a breach of these
            Terms &amp; Conditions. You acknowledge and agree that Submissions are non-confidential and non-proprietary.
            We take no responsibility and assume no liability for any Submissions posted or submitted by you. We have no
            obligation to post your comments; we reserve the right in our absolute discretion to determine which
            comments are published on the Site. If you do not agree to these Terms &amp; Conditions, please do not
            provide us with any Submissions.</p>

        <p>You are fully responsible for the content of your Submissions, (specifically including, but not limited to,
            reviews posted to this Site). You represent and warrant, as part of your act of Submission, that (a) you are
            the owner of the content of your Submissions, or have been granted all the rights necessary from the owner
            thereof to provide such Submissions to <strong>flightsgyani.com</strong> and for the use by <strong>flightsgyani.com</strong>
            as stated above, and (b) the use of such Submissions by <strong>flightsgyani.com</strong> will not infringe
            the intellectual property rights of or otherwise violate the rights of any third party. You shall be solely
            liable for any damages resulting from any infringement of copyright, trademark, or other proprietary right
            or any other harm resulting from your use of the Site and <strong>flightsgyani.com</strong>&#39;s use of
            your Submissions.</p>

        <p>You are prohibited from posting or transmitting to or from this Site: (a) any unlawful, threatening,
            libelous, defamatory, obscene, pornographic, or other material or content that would violate rights of
            publicity and/or privacy or that would violate any law; (b) any commercial material or content (including,
            but not limited to, solicitation of funds, advertising, or marketing of any good or services); and (c) any
            material or content that infringes, misappropriates or violates any copyright, trademark, patent right or
            other proprietary right of any third party. You shall be solely liable for any damages resulting from any
            violation of the foregoing restrictions, or any other harm resulting from your posting of content to this
            Site or any Submission. You acknowledge that <strong>flightsgyani.com</strong> may exercise its rights (e.g.
            use, publish, delete) to any content you submit without notice to you and without any payment of any kind.
            If you submit more than one review for the same hotel, only your most recent submission is eligible for use.
        </p>

        <p class="text-center bold">REPORTING CLAIMS OF COPYRIGHT INFRINGEMENT</p>

        <p>If you believe that materials hosted by us infringe your copyright, please submit (or have your agent submit)
            to us a notice under the Digital Millennium Copyright Act (DMCA) including all of the information requested
            below. If you fail to provide all of the requested information, we will not process your notice. You may
            wish to seek legal counsel prior to submitting a copyright infringement notice. You could be held liable for
            alleging false claims of copyright infringement.</p>

        <ul>

            <li>A physical signature of the person authorized to act on behalf of the owner of the copyrighted work;
            </li>

            <li>A description of the copyrighted work that you claim has been infringed upon;</li>

            <li>A description of where the material that you claim is infringing is located on the Site;</li>

            <li>Your address, telephone number, and e-mail address;</li>

            <li>A statement by you that you have a good-faith belief that the disputed use is not authorized by the
                copyright owner, its agent, or the law;
            </li>

            <li>A statement by you, made under penalty of perjury, that the above information in your notice is accurate
                and that you are the copyright owner or authorized to act on the copyright owner&#39;s behalf.
            </li>
        </ul>


        <p>We reserve the right in appropriate circumstances to remove content on the Site alleged to be infringing
            without prior notice, and/or to terminate the accounts of users who infringe any intellectual property
            rights of others.</p>

        <p class="text-center bold">MISCELLANEOUS GENERAL TERMS &amp; CONDITIONS AUTHORITY TO SEND COMMUNICATION</p>

        <p>By using this Site, making a travel reservation or booking, or approving this transaction you are authorizing
            <strong>flightsgyani.com</strong> to send you communication in the form of email, postal mail, instant
            messaging, phone call and any other form of electronic or paper communication. These communications will be
            primarily for customer service and may include special offers.</p>

        <p class="text-center bold">COPYRIGHT AND TRADEMARK NOTICES</p>

        <p>&copy; 2018 &quot;<strong>flightsgyani.com</strong>&quot; and &quot;<strong>flightsgyani.com</strong> the
            only way to go!!&quot; are registered trademarks. Anyone accessing this website may view and print material
            from this website for information purposes only. Any copyright material of this website is strictly
            restricted to non-commercial use only and must include this copyright notice. Other trademarks and service
            marks displayed on this Site are the trademarks and service marks of their rightful owners.</p>

        <p class="text-center bold">TERMINATION</p>

        <p>We reserve the right, in our sole discretion, and without liability, to terminate your access to all or part
            of the Site, with or without notice, for any reason or no reason.</p>

        <p class="text-center bold">SEVERABILITY</p>

        <p>These Terms &amp; Conditions are severable. In the event that any provision is determined to be unenforceable
            or invalid, such provision shall nonetheless be enforced to the fullest extent permitted by applicable law,
            and such determination shall not affect the validity and enforceability of any other remaining
            provisions.</p>

        <p class="text-center bold">NO WAIVER</p>

        <p>No failure on the part of <strong>flightsgyani.com</strong> to enforce any part of these Terms &amp;
            Conditions shall constitute a waiver of any of <strong>flightsgyani.com</strong>&#39;s rights under these
            Terms &amp; Conditions, whether for past or future actions on the part of any person. Neither the receipt of
            any funds by <strong>flightsgyani.com</strong> nor the reliance of any person on
            <strong>flightsgyani.com</strong>&#39;s actions shall be deemed to constitute a waiver of any part of these
            Terms &amp; Conditions. Only a specific, written waiver signed by an authorized representative of <strong>flightsgyani.com</strong>
            shall have any legal effect whatsoever.</p>

        <p class="text-center bold">DATA SCRAPING</p>

        <p>If you abuse this Site with numerous scans, data scraping, or screen scraping, we reserve the right to
            terminate your access to this Site immediately, without notice.</p>

        <p class="text-center bold">NO RELATIONSHIP</p>

        <p>Nothing contained in these Terms &amp; Conditions shall be deemed or construed as creating a joint venture,
            partnership, independent contractor or employment relationship between us or any of the parties hereto based
            on your use of the Site or making travel reservations or bookings. Neither you nor
            <strong>flightsgyani.com</strong> is, by virtue of these Terms &amp; Conditions, authorized as an agent,
            employee or legal representative of the other party. No party shall have any power or authority to bind or
            commit any other party.</p>

        <p class="text-center bold">SERVICE HELP</p>

        <p>For quick answers to your questions or ways to contact us, visit our Customer Support Center. Or, you can
            write to us at:</p>

        <p>Attn: Customer Service - <strong>flightsgyani.com</strong><br/>

            Kantipath,2<sup>nd</sup> floor,Opposite of Jyoti Bhawan <br/>
            Kathmand,Nepal</p>

        <p>info@<strong>flightsgyani.com</strong><br/>
            &copy;2020 <strong>flightsgyani.com</strong> All rights reserved.</p>


    </div>
@endsection
