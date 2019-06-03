<tr>
    <td class="header" background="{{ asset('/images/headers/newsletter-bg.jpg') }}" bgcolor="#222222" valign="top">
        <!--[if gte mso 9]>
        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:1982px;height:541px;">
            <v:fill type="tile" src="{{ asset('/images/headers/newsletter-bg.jpg')}}"
                    color="#222222"/>
            <v:textbox inset="0,0,0,0">
        <![endif]-->
        <div>
            <a href="{{ $url }}">
                <img src="{{ asset('/images/logos/logo.png') }}" alt="{{ $slot }}" title="{{ $slot }}">
            </a>
        </div>
        <!--[if gte mso 9]>
        </v:textbox>
        </v:rect>
        <![endif]-->
    </td>
</tr>
