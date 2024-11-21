<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mt-3">
                    <div class="text-center"><img src="logo.png" height="50"></div>
                    <div class="mt-4">
                        <div class="form-group">
                            <label>Промокод </label>
                            <input type="text" required class="form-control " v-model="form.promo">
                        </div>
                        <div class="form-group d-flex flex-row-reverse justify-content-end mt-2">
                            <label for="checkbox" style="margin-left: 10px"><a href="www.google.com" target="_blank">Келісім шартпен</a> таныстым</label>
                            <input type="checkbox" id="checkbox" v-model="form.is_agree" required class="form-check">
                        </div>
                    </div>
                    <div class="mt-3 w-100">
                        <button class="btn-danger btn w-100" @click="startSpin">Айналдыру</button>
                    </div>
                    <div class="d-flex justify-content-center mt-3 align-items-center">
                        <FortuneWheel
                            style="width: 500px; max-width: 100%;"
                            ref="wheelEl"
                            type="image"
                            :useWeight="false"
                            :verify="canvasVerify"
                            :angleBase="-5"
                            :prizes="prizesImage"
                            @rotateStart="onImageRotateStart"
                            @rotateEnd="onRotateEnd"
                        >
                            <template #wheel>
                                <div id="wheel-container" style="width: 414.8px; height: 414.8px; position: relative; margin: 0px auto;"><div id="wheel-svg"><div style="width: 414.8px; height: 414.8px; position: absolute; top: 0px; left: 0px; z-index: 200; pointer-events: none;"><svg width="414.8" height="414.8" viewBox="-207.4 -207.4 414.8 414.8"><defs><mask id="border"><circle r="187.59798994974875" fill="white"></circle><circle r="177.77142857142857" fill="black"></circle></mask><pattern id="pattern" patternUnits="userSpaceOnUse" x="0" y="0" width="70" height="70" viewBox="0 0 64 64"><image xlink:href="data:image/png;base64,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sB2EZd73vBMaz+crltGXnvFqnvvzLEZxGUrnqizMiwqsfbEzq3LDKtZuB/6h+EFsR2kWiZ/EW1EaGTa7fppMwx9Pc5vlOLs4N33VJi7HnOJhM2LKhISKnjRT5wiHPalLQcA9JaE0IVZvppmKG1EpJ5cD0UCk2zTkbdR5nlJG8pjIyyTckcrT5GH+93vt46zetNbneVAEdWtB1RqP4f0RVoaw+gxL1w1Z3d9va5hx6pl/vvELBmJQdFrQ128AAA0caVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pgo8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJYTVAgQ29yZSA0LjQuMC1FeGl2MiI+CiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiCiAgICB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIKICAgIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiCiAgICB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iCiAgICB4bWxuczpHSU1QPSJodHRwOi8vd3d3LmdpbXAub3JnL3htcC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgeG1wTU06RG9jdW1lbnRJRD0iZ2ltcDpkb2NpZDpnaW1wOmMzN2JhMDJhLWE0YTEtNGU5OC05ZmNkLThhMjJiNWQ4NzAxZiIKICAgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpjNzc2YjRhNy0yMWNkLTQ3YzItYjBlNS1kMjZlNjM2YjUyMTkiCiAgIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpkNjlkZTJlZC1kYjY0LTQxODAtYWY2YS1kMGQxMmYwZjdkOTgiCiAgIGRjOkZvcm1hdD0iaW1hZ2UvcG5nIgogICBHSU1QOkFQST0iMi4wIgogICBHSU1QOlBsYXRmb3JtPSJNYWMgT1MiCiAgIEdJTVA6VGltZVN0YW1wPSIxNjQ5NDA0MTIzNjQ1MTEzIgogICBHSU1QOlZlcnNpb249IjIuMTAuMzAiCiAgIHRpZmY6T3JpZW50YXRpb249IjEiCiAgIHhtcDpDcmVhdG9yVG9vbD0iR0lNUCAyLjEwIj4KICAgPHhtcE1NOkhpc3Rvcnk+CiAgICA8cmRmOlNlcT4KICAgICA8cmRmOmxpCiAgICAgIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiCiAgICAgIHN0RXZ0OmNoYW5nZWQ9Ii8iCiAgICAgIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6ZmNiOWM0MzQtM2VlZC00MGYzLWJmYjMtNDQwMzdmMDJmYTRiIgogICAgICBzdEV2dDpzb2Z0d2FyZUFnZW50PSJHaW1wIDIuMTAgKE1hYyBPUykiCiAgICAgIHN0RXZ0OndoZW49IjIwMjItMDQtMDhUMTA6NDg6NDMrMDM6MDAiLz4KICAgIDwvcmRmOlNlcT4KICAgPC94bXBNTTpIaXN0b3J5PgogIDwvcmRmOkRlc2NyaXB0aW9uPgogPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8P3hwYWNrZXQgZW5kPSJ3Ij8+AxRW1QAAAAJiS0dEAP+Hj8y/AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH5gQIBzArSkgFJgAADXdJREFUaN5FmVGS5LhyBN0TIKt69plOpPtfQEfR7nQXCSD0Ac7ql91GohLIyAiH//PfQmVycCuFQEGWNweyeHFn0Sk+fnEhK2WxsmxIclFCEUIBi5CUjd90oCWU5gLiDMQXxeDsVqbaCW9molQgyDvl4ODOP37lx6L4MDJpdpJhhwwHZej0XM4Mgsj0yMeWASq5kYmuTLpf+VjB1nPRAWgZojRKuJHpRO5oz4AIDhZLKPBggdKVRXEbujOYhMYk6BczywLgJYkrxaQok9ERMyQfzETClzfmh2bxzmJlII0wgNCylMXMMBke+aaEA3NbTx1JLCpT7Oid/Y5KnHRuZjrfHbmtDCZfhiOXVyahk0wutFLWv4sIpzdyMH1l2HJ50ilWhg2ZT4WKIhaTZHqYXIknofb/eKe6pqG/GDQ6TdA3K7AsikH5YvqFGU+h3wwCLI12GnewEW66BQzCwSIsGiqTMHwlrkyPFNKsTjPAZGbQvZGVQWyQxZIsLxoDnCnJx8mxz3oaAzI9nIic+QYPegbfFp2QwKQx/AX2XBYFks7s+ew/8nZgGrcLEGgMzpSTO5ctk+ZEX7lsiCwXdxrmbxvTg0HszL3bnAkDCeGmZSAXkw5Wbu/YbawomSluCugmBD5WPpz5uKx8aCaHyS0sBEa6bwfwF2Ei8YubFgyvTN/03Ki8M30UgWSyaPS9fzJ4WRn24KIzmAx6iubkyG3j0OiiWXwzIjrt3Fm+mOxdlouiC8WymJSdln8YhMYyFGXt5Wb2LDtJgZ3uYmU4NGUjuTjoLm4IJIOuKWUpnUKuDAl0FwQWP8jgINy+GJm7zhmuNCbFB7ZSlJK9KhaffFKswNQMQjL5J1cai5PGVoUED8Ijv4YwJZUtUMVCbj4m35F9qi7Nooydt6edl6+exkWYhIPBMIkv9i/8sPyLsBi8aLYsO4sWCL+4mRlWJvjO5clNp4CTYdvnXzlzI+ammZTxDh7OzM430IROR4uXkysTPTg103IRvvjAnhyUyc3g9kSaJ3LbkU7LZWdx5m/e7m4qz8SicWdYCYvOYkG3QciN/mRx8revNMkVuT3Zqt4eEcae2yvlgbifcXkkDP+0L8wsOwaluAkzWIlvhhdkRRbVUwTstNwWUmg4ieGdRefmoPjQCZPO4mUxmJhypHxRmp8Mmi+TWMB7r2cv1g+kLMjkpWarbHdSVPDPJG9cVEQAF9Ih08ng8M00JIN4g2/CFSyWJ5PBxY3Zx05m8IPPqRgsgq6EPV7TOfKxu3W9rPwIxY2cmXSTj93JEVheFLIMK0HhRTkhEhrw8XTxYmbZiEemACMXC+18pyNFJ7HT6JFhpzTxgEdO3U7Cv3ILsdGBO+HHE5gUI4PJpCHRXJibSSxHlh0YtCwB3xlZvDhcnAygd/DFpLIYlD2L+5mQFyYWl0EmxSLMbb+yOJ+PkiIMKqAnd3bpcWZ//sZt4sBGQco7y8PRWbm3X1EWF4vGabIy/EUIk8FJ38M1Yx89inJyJHQG2zEc9lyeks5I93BFisVNpZBOgmhuj1zY881IszHTWZQtM5Np48UdlaSBLcuksaXzRleWSxP+rUiWbxa38yl/t2V40LLAI4upzMRGrN0uL6T4Ek7MBBY95Jvlyie3cBFg8OFmEDpkIVJM4LZ7ADP7WXECi0k8kBe6LW0xoyt3BnF1miekAA2v3Fa+vFO+SZbwZvFiutgDKlZ+aBSLg9uW21+sbcLy4cUhWVk07yyLBhaTgazgC30nLGancu2RnCiH5uKmUQRZiWGxve5Cy22tdvFvIHQmfbtfO+OPD85Kr557vyvdg4+NxsxQJlKdmyX0hBX5ZtlTWRQfmkQkJqE8MiGTw33oRhow6BnO3MAXi+yt9DZ77xMrNy03yQforEyuBDsvK4tpe1xvgUHudE+GIwNskGlsWb6ehrw5NfGksmBLC5VVKyodkEGZLA9GsG+zDgz+w510Oyf/y8ECEpwIgcbIR3LbA/VItczAZaU9Z6RyAT2TckQxS39xMfnaKSmncwsbalRaGoNydkg4CYMvpkkxPVhWttE4kEqURsuHstGIi5FS8Mz0oOcT6JkewpX5SNKw+5OX4VCyxx3T8LUP4XDlsif8MDkZNC6LPE1VaZo7wxcfipnGQDvlYmVZmMu3byYtobNQE7TRIJcjcVKEBbT8Bjpip2fQMrYpydBcOVzsT7csF9OTotLdxcYwMi1OB9087v/l6T+4l+UiQCjDbYKVplbWNjIcmZ2PO/uZcwcpWz78it5JQiGNlZtJp4ErN2e0Mr2BkZty68Dvf+O5WR65lEmlvKzoouh8s5vx+48Rkzd7EdvxvNA7jb1v23CXr8z9WluWJxcVPIOvR+13nLu2DnruaZtyAu/k4Q5DdoL2xd0xvz246XxyOCkJXhx2blYWh8WgU94syWXZ8yMWPeX1b7RfyRM4fnNQFuE3Fbc3dBvgzkuJDTl6vv3Kzf6EVBrBNDs/ezhxs4/qYvKzjxiDI8Oemx86t4PKZGHKrwzfGfz4Jry9cTcwP5nKyY2Qjx27X1kcO63km3qMgvn4ArKPXMruYkezI8v2iMzNCsALmGyQM7gj5ZmPJkyPx6Jtu/MdONAGzM60ePNBLk7CDzB3qsnOjhCltush4J/d1hZtdMa23092OhIXg5mXZjckuTgh024gnxS3vai03IHiC2l2yi0ZzTOTScG/n18pZhYT0jaoCZmAmyzZKRoEypNkIZOZzsFBbDQqw/dmKgWuR36XfY/MDPRXkvuxjudmBcgCT0CbxSIZLIGkijMjoWWijQpg9+V7c6R8uDOBoZtCcfTojl4HjZWLQziz/CiLUJlAHFRuStGeogiNZnLT6d7rBguelPixa+6cTmLlx5MXH5PhSXBnyy6Znt5ZXFG5E4rK8pXJYBK3eIaDSWMbthFoEuwkPzR7VuYD5lYaUH7RuIBuz8d7gxoql40Xg3ReNhaHecxV+WIGDU+KX3SWvyA3RaW5aOABDEN74JQMD0CKmAyLxqJlsjx8P1n6Db4yjdA6+6W3RaMBxYheuONjsHMFsAnksjI9CTM/QudmUbQN57g0F2fG9j60XS+uxxdhMTiURWMUr8DyyH4gE1wxsbE2E+VF982RrMuTcGbkYrCyvV/RMiEXN0dK86PAAAr55MqN3Ex+88Pgm4Wc2Lm8KaYVHNH5sIFi8YubI3Eq4Vb/iz39oKEnM9houeh2OosBiW/aE2U+KZtvwuBg8Z/oZGURF624cWcFPky+n76XMPOdwfRiURhpWdyEPOatP6Rk+drckBYs3hSVgel8cRA++Z3BTcw+igYzWZ0kjJQHKz90zN926uG5yd/+oufbbljwzLbs02wYCcuDk4rcDl5uZNVyP2mxWww+kNDRljBozHw6h22zCt+YleWLDi5+MfnwiuhJ54fSQOWWlH3HcH/l4Fu4leTYnQEuoDQ6A/iLuRUni8nhmd+0nusBi2RYTk7CxSs3cUUb8WYR2HGd5UH5m+SDnrm5803znR/DcqfAm7VZsi2xUhnWzlToKzCY9O4evz905QA+OZmE0/lghJll5RaTycnMcOv6i5aLcPlXwqKyHrpYTI6U556cmeCR2yPDlhbdXG72dIbu8rsYyJ7zk0bfeq+ZJNg99u5nWrg/ip5AwL/yG610bjovL+RgKeHgsgfeDNeDsIvqfO+9FBeNymEeE94tGj+01NY+RqakCWFyuBH9wcliZgldE0fC4tsi3mxYtfjFhfzk8Mg3k0VJt4Ldi5ZwPXT0CUe0rZPCi7mhw1O8O+Vk0n1ncdmYmLXBdzrFtMOD6y/rYSSTerpmcXBn9R2XuA0+KbYysu+SyOagcD0L2aAS8EVxZTA9eD02RheNcHkCcNFy+GHfJCxaht1kKrIybWXLZHhSNmYWP+AXg9M9zRsGzuQPcE1jkcxMjocTbO902nLQcacpttqMx9iZyXQluR0ZeSrd00zuxBdrS0jCTeUfmoM7eHIwmLyfmHrnty+GJL74In+6HSDXdsO5mQxeWTQGk+aDc+ybEOTjOz+dPSbqIYQt0/9XwWWzZzASTj62/OTLm9fjBMTn8uJkpdkdyMzh0Jx+OHkz0/gBGn9z0FLc3PunsHYwGVm57MDF2vQ8G1E2ltBoj4S8PLgoFic3I99+ARd4MDMdtJwbanKnJMPm5inxncY0FAcDuUkn9sSeRTky7KnHBZltL5c3K9jQ7X0aY2NXZdDY47e7k+DKRbccnAw7147+kOWiEsnnWVrrFuwm2kyLwWI71/VIzptJXLnpNslv3sHJgDSWyWWnGLk5+QdsO3zk45nhCnvg2xOfa8+Hls6CSFG+aFSKk4ObgHqkfJGnC2Tkk4t33LEqcNlpNsLKVP/QlG9WZJscbOCZStnovIGTqZjqDA9Cy+WkuyiGb57k87jcP26RnG4GvM1qZeW3Rybzodtli1z0x9T4kLRijyIJv8EEPjRacfzr+GVmMEgGg+LOlZvB2jdFHjldaS5WyMiiGU/goHHsiUo5KWfaQ0iTSWVsD0QgRcsFVELruajEW3YR90U7i5lJ7ct3JgOYhpeTeghK5WPPUjtnohm7DDRO7x1yd8/ok7FexMUeZdNi/h+ixm8OQXsb9QAAAABJRU5ErkJggg==" opacity="0.4"></image></pattern></defs><circle r="187.59798994974875" mask="url(#border)" fill="rgba(255, 255, 255, 0.5)"></circle><g class="wheel-knob"><path d="M -9.551315785982705 -26.027335506814314
                   L 0 -42.98092098193927
                   L 9.551315785982705 -26.027335506814314
                   A 28.716923076923077 28.716923076923077 0 1 1 -9.551315785982705 -26.027335506814314
                   Z" fill="black" stroke-width="3.7332" stroke-linejoin="round" stroke="white" pointer-events="auto"></path>
                                    <text font-size="19.64842105263158" font-family="VanillaExtractRegular" fill="white" height="19.64842105263158" text-anchor="middle" y="7.4664" pointer-events="none">Spin</text></g></svg>
                                </div>
                                    <div style="position: absolute; top: 0px; left: 0px; z-index: 100; width: 414.8px; height: 414.8px; touch-action: none; pointer-events: none;">
                                        <div class="innerWheelContainer" style="transform: rotate(0deg); animation: auto ease 0s 1 normal none running none;">
                                            <svg id="wheel-cpt" width="414.8" height="414.8" viewBox="-207.4 -207.4 414.8 414.8"><g pointer-events="none"><g>
                                                <path d="M 186.65907887057884 -0.5864087201142794
  A 186.66 186.66 0 0 1 150.66568456317307 110.18986838684593
  L 0 0 Z" fill="#5b0e04" class="cone false"></path><path d="M 151.35504935817082 109.24103914640172
  A 186.66 186.66 0 0 1 57.123119690905554 177.70454354568
  L 0 0 Z" fill="#c62608" class="cone false"></path><path d="M 58.238535359859526 177.34212302535005
  A 186.66 186.66 0 0 1 -58.238535359859505 177.34212302535005
  L 0 0 Z" fill="#fc5a12" class="cone false"></path><path d="M -57.12311969090553 177.70454354568
  A 186.66 186.66 0 0 1 -151.35504935817085 109.2410391464017
  L 0 0 Z" fill="#fecf39" class="cone false"></path><path d="M -150.66568456317307 110.18986838684593
  A 186.66 186.66 0 0 1 -186.65907887057884 -0.5864087201142199
  L 0 0 Z" fill="#5c8408" class="cone false"></path><path d="M -186.65907887057884 0.5864087201142656
  A 186.66 186.66 0 0 1 -150.66568456317316 -110.18986838684583
  L 0 0 Z" fill="#5b0e04" class="cone false"></path><path d="M -151.35504935817082 -109.24103914640172
  A 186.66 186.66 0 0 1 -57.12311969090561 -177.70454354567997
  L 0 0 Z" fill="#c62608" class="cone false"></path><path d="M -58.238535359859505 -177.34212302535005
  A 186.66 186.66 0 0 1 58.23853535985945 -177.34212302535005
  L 0 0 Z" fill="#fc5a12" class="cone false"></path><path d="M 57.12311969090554 -177.70454354568
  A 186.66 186.66 0 0 1 151.3550493581708 -109.24103914640177
  L 0 0 Z" fill="#fecf39" class="cone false"></path><path d="M 150.66568456317307 -110.18986838684596
  A 186.66 186.66 0 0 1 186.65907887057884 0.5864087201141971
  L 0 0 Z" fill="#5c8408" class="cone false"></path></g><g>
                                    <defs>


                                        <path id="textPath-1" d="M 100.48802168144184 136.9480957549614
                    L 11.042639745213389 15.049241291753999"></path><path id="textPath-2" d="M 0.8004462571008915 169.85871398944917
                    L 0.08796112715394411 18.665792746093313"></path><path id="textPath-3" d="M -99.19287243128494 137.88907676531463
                    L -10.900315651789555 15.152645798386224"></path><path id="textPath-4" d="M -161.29788529265238 53.250498894173255
                    L -17.72504233985191 5.851703175183875"></path><path id="textPath-5" d="M -161.79258828570838 -51.727959636653566
                    L -17.7794053061218 -5.68439116886303"></path><path id="textPath-6" d="M -100.48802168144184 -136.9480957549614
                    L -11.042639745213389 -15.049241291753999"></path><path id="textPath-7" d="M -0.8004462571010255 -169.85871398944917
                    L -0.08796112715395885 -18.665792746093313"></path><path id="textPath-8" d="M 99.192872431285 -137.8890767653146
                    L 10.90031565178956 -15.15264579838622"></path><path id="textPath-9" d="M 161.29788529265238 -53.250498894173276
                    L 17.72504233985191 -5.851703175183877"></path>
                                </defs>
                                    <text font-size="19.9104" height="16" text-anchor="start" letter-spacing="0" class="label cone false" fill="#fdfbd1">
                                        <textPath xlink:href="#textPath-0" startOffset="0"><tspan x="0" dy="0em" alignment-baseline="middle">Chocolates</tspan>
                                        </textPath>
                                    </text>
                                    <text font-size="19.9104" height="16" text-anchor="start" letter-spacing="0" class="label cone false" fill="#fdfbd1">
                                        <textPath xlink:href="#textPath-1" startOffset="0">
                                            <tspan x="0" dy="0em" alignment-baseline="middle">Tea Mug</tspan>
                                        </textPath>
                                    </text>
                                    <text font-size="19.9104" height="16" text-anchor="start" letter-spacing="0" class="label cone false" fill="#fdfbd1">
                                        <textPath xlink:href="#textPath-2" startOffset="0">
                                            <tspan x="0" dy="0em" alignment-baseline="middle">Candy</tspan></textPath></text><text font-size="19.9104" height="16" text-anchor="start" letter-spacing="0" class="label cone false" fill="#fdfbd1"><textPath xlink:href="#textPath-3" startOffset="0"><tspan x="0" dy="0em" alignment-baseline="middle">Phone Case</tspan></textPath></text><text font-size="19.9104" height="16" text-anchor="start" letter-spacing="0" class="label cone false" fill="#fdfbd1"><textPath xlink:href="#textPath-4" startOffset="0"><tspan x="0" dy="0em" alignment-baseline="middle">Cookies</tspan></textPath></text><text font-size="19.9104" height="16" text-anchor="start" letter-spacing="0" class="label cone false" fill="#fdfbd1"><textPath xlink:href="#textPath-5" startOffset="0"><tspan x="0" dy="0em" alignment-baseline="middle">Bracelet</tspan></textPath></text><text font-size="19.9104" height="16" text-anchor="start" letter-spacing="0" class="label cone false" fill="#fdfbd1"><textPath xlink:href="#textPath-6" startOffset="0"><tspan x="0" dy="0em" alignment-baseline="middle">Cupcakes</tspan></textPath></text><text font-size="19.9104" height="16" text-anchor="start" letter-spacing="0" class="label cone false" fill="#fdfbd1"><textPath xlink:href="#textPath-7" startOffset="0"><tspan x="0" dy="0em" alignment-baseline="middle">Keychain</tspan></textPath></text><text font-size="19.9104" height="16" text-anchor="start" letter-spacing="0" class="label cone false" fill="#fdfbd1"><textPath xlink:href="#textPath-8" startOffset="0"><tspan x="0" dy="0em" alignment-baseline="middle">Brownie</tspan></textPath></text><text font-size="19.9104" height="16" text-anchor="start" letter-spacing="0" class="label cone false" fill="#fdfbd1"><textPath xlink:href="#textPath-9" startOffset="0"><tspan x="0" dy="0em" alignment-baseline="middle">Pendant</tspan></textPath></text></g><path id="cone-overlay" d="M 0 0
  A 186.66 186.66 1 1 0 0 0
  L 0 0 Z" fill="white" class="cone-overlay false"></path></g><circle r="186.66" fill="url(#pattern)" pointer-events="fill"></circle></svg></div></div>
                                    </div></div>
<!--                                <img src="https://xiaolin1995.github.io/vue-fortune-wheel/demo/assets/wheel-fe56734c.png" style="width: 100%;transform: rotateZ(60deg)" />-->
                            </template>
                            <template #button>
<!--                                <img src="https://pngimg.com/d/buttons_PNG149.png" style="width: 180px"/>-->
                                <img src="https://xiaolin1995.github.io/vue-fortune-wheel/demo/assets/button-e4d3ef80.png" width="100" alt="">
                            </template>
                        </FortuneWheel>

                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-2 footer">
                        © 2024 "Ozge" бренд коллекциясы
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FortuneWheel from 'vue-fortune-wheel'
import 'vue-fortune-wheel/style.css'
import CryptoJS from "crypto-js";
    export default {
        components: {
          FortuneWheel,
        },
        data() {
          return {
              key: import.meta.env.VITE_API_KEY,
	      isLoading: true,
              form:{
                  promo: null,
                  is_agree: true
              },
              canvasVerify: false,
              canvasOptions: {
                  borderWidth: 6,
                  borderColor: '#bb708e',
                  textDirection: "vertical",
                  btnWidth: 80,
                  fontSize: 16,
                  textLength: 10,
                  btnText: '',
                  disabled: true,
              },
              prizes:[],
              prizesImage:[
                  {
                      id: 1,
                      value: 'Keychain', //* Prize value, return value after spinning
                      probability: 10
                  },
                  {
                      id: 2,
                      value: 'Brownie',
                      probability: 10
                  },
                  {
                      id: 3,
                      value: 'Pendant',
                      probability: 10
                  },
                  {
                      id: 4,
                      value: 'Chocolates',
                      probability: 10
                  },
                  {
                      id: 5,
                      value: 'Tea Mng',
                      probability: 20
                  },
                  {
                      id: 6,
                      value: 'Candy',
                      probability: 0
                  },
                  {
                      id: 7,
                      value: 'Phone Case',
                      probability: 10
                  },
                  {
                      id: 8,
                      value: 'Cookies',
                      probability: 10
                  },
                  {
                      id: 9,
                      value: 'Bracelet',
                      probability: 20
                  },
                  {
                      id: 10,
                      value: 'Cupcakes',
                      probability: 0
                  },
              ]
            }
        },
        mounted() {

            console.log('Component mounted.')
        },
        created() {
            this.getPrizes()
        },
        methods: {
            onImageRotateStart () {
                console.log('onImageRotateStart')
            },
            onCanvasRotateStart(rotate) {
                if (this.canvasVerify) {
                    const verified = true // true: the test passed the verification, false: the test failed the verification
                    this.DoServiceVerify(verified, 500).then((verifiedRes) => {
                        if (verifiedRes) {
                            console.log('Verification passed, start to rotate')
                            rotate()
                            this.canvasVerify = false
                            this.canvasOptions.disabled = true
                        } else {
                            alert('Failed verification')
                        }
                    })
                }else{
                    console.log('not allowed')
                }
                console.log('onCanvasRotateStart')
            },
            encryptP(value, apiKey) {
                return CryptoJS.AES.encrypt(value.toString(), apiKey, {}).toString();
            },
            startSpin(){
                if (this.form.promo === null || !this.form.is_agree){
                    this.$swal.fire({
                        icon: "error",
                        title: "Ошибка",
                        text: "Проверьте все поля!",
                    });
                }else{
                    axios
                        .post('/prizes/check', this.form)
                        .then((response) => {
                            this.canvasVerify = true
                            this.canvasOptions.disabled = false
                            setTimeout(function () {
                                document.getElementsByClassName('fw-btn__btn')[0].click()
                            }, 200)
                        }).catch((error) => {
                            this.$swal.fire({
                                icon: "error",
                                title: "Ошибка",
                                text: error.response.data.msg,
                            });
                        })
                }


            },
            onRotateEnd(prize) {
                console.log(prize)

            },
            getPrizes(){
                axios
                    .get('/p-list')
                    .then((response) => {
                        let data = response.data;
                    	this.prizes = data;
			this.isLoading = false;
			}).catch((error) => {
      				this.isLoading = false; // Ensure the loading state is false even if there is an error
      				console.error('Error fetching prizes:', error);
      				// Handle the error gracefully (e.g., show a message to the user)
    			});;
            },
            // Simulate the request back-end interface, verified: whether to pass the verification, duration: delay time
            DoServiceVerify(verified, duration) {
                return new Promise((resove) => {
                    setTimeout(() => {
                        resove(verified)
                    }, duration)
                })
            }
        }
    }
</script>

