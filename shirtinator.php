<?php
/*
Plugin Name: Shirtinator
Plugin URI: http://shirtinator.de/
Description: Insert your personal Shirtinator Creator wrapped into WordPress without any popup or iframe.
Version: 0.4
Author: Frank B&uuml;ltge
Author URI: http://bueltge.de/
Revision: 17.10.2008 10:23:56 
*/

// Pre-2.6 compatibility
if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( !defined( 'WP_PLUGIN_URL' ) )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( !defined( 'WP_PLUGIN_DIR' ) )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

define('SHIRTINATOR_PAGE', '<!--shirtinator-->');

// Icons
if( isset($_GET['resource']) && !empty($_GET['resource'])) {
	# base64 encoding performed by base64img.php from http://php.holtsmark.no 
	$resources = array(
		'shirtinator.png' =>
			'iVBORw0KGgoAAAANSUhEUgAAAMgAAAAwCAYAAABUmTXqAAAACX'.
			'BIWXMAAAsTAAALEwEAmpwYAAAKT2lDQ1BQaG90b3Nob3AgSUND'.
			'IHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4'.
			'AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2Afk'.
			'IaKOg6OIisr74Xuja9a89+bN/rXXPues852zzwfACAyWSDNRNY'.
			'AMqUIeEeCDx8TG4eQuQIEKJHAAEAizZCFz/SMBAPh+PDwrIsAH'.
			'vgABeNMLCADATZvAMByH/w/qQplcAYCEAcB0kThLCIAUAEB6jk'.
			'KmAEBGAYCdmCZTAKAEAGDLY2LjAFAtAGAnf+bTAICd+Jl7AQBb'.
			'lCEVAaCRACATZYhEAGg7AKzPVopFAFgwABRmS8Q5ANgtADBJV2'.
			'ZIALC3AMDOEAuyAAgMADBRiIUpAAR7AGDIIyN4AISZABRG8lc8'.
			'8SuuEOcqAAB4mbI8uSQ5RYFbCC1xB1dXLh4ozkkXKxQ2YQJhmk'.
			'AuwnmZGTKBNA/g88wAAKCRFRHgg/P9eM4Ors7ONo62Dl8t6r8G'.
			'/yJiYuP+5c+rcEAAAOF0ftH+LC+zGoA7BoBt/qIl7gRoXgugdf'.
			'eLZrIPQLUAoOnaV/Nw+H48PEWhkLnZ2eXk5NhKxEJbYcpXff5n'.
			'wl/AV/1s+X48/Pf14L7iJIEyXYFHBPjgwsz0TKUcz5IJhGLc5o'.
			'9H/LcL//wd0yLESWK5WCoU41EScY5EmozzMqUiiUKSKcUl0v9k'.
			'4t8s+wM+3zUAsGo+AXuRLahdYwP2SycQWHTA4vcAAPK7b8HUKA'.
			'gDgGiD4c93/+8//UegJQCAZkmScQAAXkQkLlTKsz/HCAAARKCB'.
			'KrBBG/TBGCzABhzBBdzBC/xgNoRCJMTCQhBCCmSAHHJgKayCQi'.
			'iGzbAdKmAv1EAdNMBRaIaTcA4uwlW4Dj1wD/phCJ7BKLyBCQRB'.
			'yAgTYSHaiAFiilgjjggXmYX4IcFIBBKLJCDJiBRRIkuRNUgxUo'.
			'pUIFVIHfI9cgI5h1xGupE7yAAygvyGvEcxlIGyUT3UDLVDuag3'.
			'GoRGogvQZHQxmo8WoJvQcrQaPYw2oefQq2gP2o8+Q8cwwOgYBz'.
			'PEbDAuxsNCsTgsCZNjy7EirAyrxhqwVqwDu4n1Y8+xdwQSgUXA'.
			'CTYEd0IgYR5BSFhMWE7YSKggHCQ0EdoJNwkDhFHCJyKTqEu0Jr'.
			'oR+cQYYjIxh1hILCPWEo8TLxB7iEPENyQSiUMyJ7mQAkmxpFTS'.
			'EtJG0m5SI+ksqZs0SBojk8naZGuyBzmULCAryIXkneTD5DPkG+'.
			'Qh8lsKnWJAcaT4U+IoUspqShnlEOU05QZlmDJBVaOaUt2ooVQR'.
			'NY9aQq2htlKvUYeoEzR1mjnNgxZJS6WtopXTGmgXaPdpr+h0uh'.
			'HdlR5Ol9BX0svpR+iX6AP0dwwNhhWDx4hnKBmbGAcYZxl3GK+Y'.
			'TKYZ04sZx1QwNzHrmOeZD5lvVVgqtip8FZHKCpVKlSaVGyovVK'.
			'mqpqreqgtV81XLVI+pXlN9rkZVM1PjqQnUlqtVqp1Q61MbU2ep'.
			'O6iHqmeob1Q/pH5Z/YkGWcNMw09DpFGgsV/jvMYgC2MZs3gsIW'.
			'sNq4Z1gTXEJrHN2Xx2KruY/R27iz2qqaE5QzNKM1ezUvOUZj8H'.
			'45hx+Jx0TgnnKKeX836K3hTvKeIpG6Y0TLkxZVxrqpaXllirSK'.
			'tRq0frvTau7aedpr1Fu1n7gQ5Bx0onXCdHZ4/OBZ3nU9lT3acK'.
			'pxZNPTr1ri6qa6UbobtEd79up+6Ynr5egJ5Mb6feeb3n+hx9L/'.
			'1U/W36p/VHDFgGswwkBtsMzhg8xTVxbzwdL8fb8VFDXcNAQ6Vh'.
			'lWGX4YSRudE8o9VGjUYPjGnGXOMk423GbcajJgYmISZLTepN7p'.
			'pSTbmmKaY7TDtMx83MzaLN1pk1mz0x1zLnm+eb15vft2BaeFos'.
			'tqi2uGVJsuRaplnutrxuhVo5WaVYVVpds0atna0l1rutu6cRp7'.
			'lOk06rntZnw7Dxtsm2qbcZsOXYBtuutm22fWFnYhdnt8Wuw+6T'.
			'vZN9un2N/T0HDYfZDqsdWh1+c7RyFDpWOt6azpzuP33F9JbpL2'.
			'dYzxDP2DPjthPLKcRpnVOb00dnF2e5c4PziIuJS4LLLpc+Lpsb'.
			'xt3IveRKdPVxXeF60vWdm7Obwu2o26/uNu5p7ofcn8w0nymeWT'.
			'Nz0MPIQ+BR5dE/C5+VMGvfrH5PQ0+BZ7XnIy9jL5FXrdewt6V3'.
			'qvdh7xc+9j5yn+M+4zw33jLeWV/MN8C3yLfLT8Nvnl+F30N/I/'.
			'9k/3r/0QCngCUBZwOJgUGBWwL7+Hp8Ib+OPzrbZfay2e1BjKC5'.
			'QRVBj4KtguXBrSFoyOyQrSH355jOkc5pDoVQfujW0Adh5mGLw3'.
			'4MJ4WHhVeGP45wiFga0TGXNXfR3ENz30T6RJZE3ptnMU85ry1K'.
			'NSo+qi5qPNo3ujS6P8YuZlnM1VidWElsSxw5LiquNm5svt/87f'.
			'OH4p3iC+N7F5gvyF1weaHOwvSFpxapLhIsOpZATIhOOJTwQRAq'.
			'qBaMJfITdyWOCnnCHcJnIi/RNtGI2ENcKh5O8kgqTXqS7JG8NX'.
			'kkxTOlLOW5hCepkLxMDUzdmzqeFpp2IG0yPTq9MYOSkZBxQqoh'.
			'TZO2Z+pn5mZ2y6xlhbL+xW6Lty8elQfJa7OQrAVZLQq2QqboVF'.
			'oo1yoHsmdlV2a/zYnKOZarnivN7cyzytuQN5zvn//tEsIS4ZK2'.
			'pYZLVy0dWOa9rGo5sjxxedsK4xUFK4ZWBqw8uIq2Km3VT6vtV5'.
			'eufr0mek1rgV7ByoLBtQFr6wtVCuWFfevc1+1dT1gvWd+1YfqG'.
			'nRs+FYmKrhTbF5cVf9go3HjlG4dvyr+Z3JS0qavEuWTPZtJm6e'.
			'beLZ5bDpaql+aXDm4N2dq0Dd9WtO319kXbL5fNKNu7g7ZDuaO/'.
			'PLi8ZafJzs07P1SkVPRU+lQ27tLdtWHX+G7R7ht7vPY07NXbW7'.
			'z3/T7JvttVAVVN1WbVZftJ+7P3P66Jqun4lvttXa1ObXHtxwPS'.
			'A/0HIw6217nU1R3SPVRSj9Yr60cOxx++/p3vdy0NNg1VjZzG4i'.
			'NwRHnk6fcJ3/ceDTradox7rOEH0x92HWcdL2pCmvKaRptTmvtb'.
			'Ylu6T8w+0dbq3nr8R9sfD5w0PFl5SvNUyWna6YLTk2fyz4ydlZ'.
			'19fi753GDborZ752PO32oPb++6EHTh0kX/i+c7vDvOXPK4dPKy'.
			'2+UTV7hXmq86X23qdOo8/pPTT8e7nLuarrlca7nuer21e2b36R'.
			'ueN87d9L158Rb/1tWeOT3dvfN6b/fF9/XfFt1+cif9zsu72Xcn'.
			'7q28T7xf9EDtQdlD3YfVP1v+3Njv3H9qwHeg89HcR/cGhYPP/p'.
			'H1jw9DBY+Zj8uGDYbrnjg+OTniP3L96fynQ89kzyaeF/6i/suu'.
			'FxYvfvjV69fO0ZjRoZfyl5O/bXyl/erA6xmv28bCxh6+yXgzMV'.
			'70VvvtwXfcdx3vo98PT+R8IH8o/2j5sfVT0Kf7kxmTk/8EA5jz'.
			'/GMzLdsAAAAEZ0FNQQAAsY58+1GTAAAAIGNIUk0AAHolAACAgw'.
			'AA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAA8RSURBVHja'.
			'7J15lFTFFcZ/3dMzI4uIIriMBnFBxQUXNEYlorgvaDRGcUncok'.
			'aNcYka96CJS0xi1BCXROOW5GhiPCpRFDcWRZSocYsbuAUFWQQc'.
			'YYCZ7vxxv3f6UVOv+/XCDNO+75w5011dr15VvXur7r11732pjf'.
			'pvQAdgKPBLoJ++zwJGAU9X8R6rAb8FdgJSwDLgEeBSIFeF9ncH'.
			'rgTWVHuzgZ8Bzxe4JgVcARwMZHTdv4EzgfnUHg4CLgRW1/dPgL'.
			'OAt7rqgDIddJ9jxSQBNgVOrDKDbAyc4JRtAPwCaKlC+ycAu4S+'.
			'bwbsU4RB+gA/AVYNlQ0CbgWeq0EGORX4ljNHB3RlBkl30H1aO+'.
			'neX1WxLd8utCzGAuRjznpqE775yHblAXUUg+Q6aeK6d/IY2oDG'.
			'iPJaRK7WxprpxHtXe+LeA/4GbBVqfxywdAUzYE+gTsSx0Pl9Lv'.
			'AHYP/QYvS6/r4u6A700K7ZCjR3ZQZZW3L21kDfmKt8ClgAvAO8'.
			'ArwW8969gZGSWesKKNIp/fa+5P0XI+q1AFPVVtDvFwqMoQewl+'.
			'6/oVb6cB/qgP8Bl8uo4MNpwJEi/hwwVjpHa2iHeQ0YoM916v/i'.
			'Ajv6bsCuwObSXbIF6n4JvAFMAiaUKDkM07PeXEyei5j7JXq2Lw'.
			'DPlCG2ngscH3ouD0iRL0Rbg9W/wSGjSBRtLAWmaV6fKsH4sSkw'.
			'XLS+ttpy5+iJlKxYGeCnwBlAUwUMtwh4VkQ1NVQ+WsTk6iWl7m'.
			'DLtCtcJmuQO6mvOmWzgfX1kMM4GrNAbRnjnmcBNwB3Ad8vUnex'.
			'jAWf6vvqYuw1nHo7AVOcsl0wS99uZc79M8BFIuRC2BW4yjGaxM'.
			'XbwDWaCx8eBA4p0sZsMeVcz28DNAeHAN3K6N+7GttdRQwnP9ez'.
			'7FWkvZa0Vs6/AldXyBzBdrq/mGS/FSDe1av9Z4AjYrTX5lkZrg'.
			'LujckcAZHHRYvTj8YIUXIV5/sJwJMVMAeYGXpcESY+SXWGlnmP'.
			'zYA7teDVVdBXn5FiOz3XkWUyB8BA9e+GCP26Sbv8GTGYA2BJGj'.
			'gFOLzKolsP4MaYnSgHq2qV2KOIguiWXaDtvVLFMwoNzm6Vi9Gv'.
			'fYHbPExTDnoCf5Lo4GJ/4JYq3ec07ByrHLR6RMwm7T79q0QfZ3'.
			'r6twrwF2BICe10y0jc8GGpRJpUkUayejAuNpbY8FiMjjQXsKhF'.
			'td8IXC9xZXFMmfOyAg9tiWesc7WyR2E68IH6Xqexzipxx/11gd'.
			'W4nHmp1+K0g0TeYEEp5z5Zrea+684H7o+hc74PfKT2U8A/pLOG'.
			'MQr4RpUX0fN1r//o+1EFduhFWrRSjvQxIROxyt8H/EaEF4dBNt'.
			'a264pomxRhkKck2s0sQgj9gEucHQMpWLsDj8aYsGPxm31v16rb'.
			'HBpr8P8zycxRuF0iWyVi0Rae8nGSxecUmZc1MU8Bd8cYJAPEQ/'.
			'q+m+R+F2OA67QQRDFIL4mAJ3kY8bsxGGQ08LsCvzepnQCTgJdD'.
			'TNkGfBvYxkPU94QW8aCvh+s5NwDHAWfr9x947j1PettkZ1cPPD'.
			'Hey0RYEx4CXirhQb+JnaK6DFJITn0POJT2ptGo9l/RQDZzfttZ'.
			'DFJMFNrRU/aI58GXglSFq9xOnrJ3gO+VYI15XfMy0CnfIcQg3/'.
			'Rc94qIKY6XwWQtUiOc8i2rMEebYW5CwU52NPCxU+cAMXMYT4jm'.
			'8Oz65+jzkJDyv6OH+U/RLlPQ3EeE+FIqxmg7DcSONzWxUXgpJn'.
			'MEmO+xXIGZowuhrYCyPaZCAq+UQXz6wHhK89Oah9/Eu27oc2/P'.
			'789RmguOT9Ssq8IchRXyhfjPSR4DfiTL3+vAHbS3ihLa9QME1s'.
			'OtPHO9AJhYrPOZAvpHqRgta1iKvP28uUrKbzERr1xirlYfqtn3'.
			'ZWW001bEUjQW2BMzcS4FZkgp7qbVu9g8tLK8P1k15y/rtJeKqH'.
			'NLyJixKOainwntIL42M3EYJB2hYKcp3R3kixW8+qaqTKApVj5U'.
			'a17CxPsv7Ux1MlYcDJwn8aZbDELPRjBItdGjSF+yRZjDlX5you'.
			'N1y+1QJkLMuQRzXf4kxkNLaauehp3qPl2iJSdBx6AZO9G+nOqZ'.
			'U6uN3phrzqshPenxItc0yQCDFPMTHQapB9aqhEEe9ygw9VJwhp'.
			'TR5gxZwK5PaHKlwsWY6//KjiPIHwLfE4NBNsIsoYUW8IZyO5MG'.
			'fi/LSbXQhAUunZ7Q5EqDkV2EOVzE8ftqjVGnbF0pA3yOnbKOxk'.
			'51q4ULMO/aeQl9dip6YVGNUbv95zHb6Qus93WbvECLny4mGSYm'.
			'2REzkXWPoTjlVNf1n1kfs5NPSGi0U7E9ZnRxcSuFPZVdnC5poy'.
			'orcxcwfCzHIMFgn9FfoPDEYZCsmOFB2h8UDkgYpNMx2FP2Puav'.
			'VIo5Px2hVJdj7exIxlhWwi7pZZBG7BQ2OL+Yh1mvlupvfox2Zm'.
			'IHNE2e7b1WEGWfX9nhM89Oo/SzLt8i2T0Gg2Q7+ZnlqCAnQQZz'.
			'Yjsh1GAzcCDRgUmlrDC5GmIQH0H16wL9bo3JNMWwTozn61tEep'.
			'RBN6XQT67IM8vS3jmyJKLeWytBd+kRffE7tnWo7LcS4kNP2SFU'.
			'HkOzojHNU7YNfpf4KKzH8g6FUfjYU3YUdoIfhQUxVYBSFq4Aga'.
			'Np2ck7MlLSXEe3kzFXkZYYRN6Gee36FMGWGmIQn99Of8xp7iYs'.
			'irBeD3wy1c2oUgleVF96OKLR/Zhb/OtaZaNEyP6YU+DAiGcfFq'.
			'HGAT926gzCXF1GY54WGc3RJNHHa2Isn7v7gZjb+lee/gWn5HsV'.
			'GHug/86rhEE+oH2E2c76qxT/rSEGmYQ57O3pIYCbnbK78btXd9'.
			'bOdw/tPV/XwEJPK8FaLO8b9QQW8ut6KQ8B/uyU3SRDwQIsCvCy'.
			'CLHu2jL7Ni90z0XlDjBNEXffCjCV5ePSuzrasFDN2THqbrGS9f'.
			'0iVkwmlY2cxXWJdpA4hp1Boc/XUv1EemdjgVoV7SBpzOX7j1Xu'.
			'3DzMJz8QsXxu0eXENBdqJ1Wkfl2JCqIP7wCHRcj1LjMFfUoXuG'.
			'+6A+YFiTYjiOHeXQbOccYxFcv08mmR68Ki2SIsBubJKvRnMeYK'.
			'f3eR55yOoyMH6WpOxQKHptA+A0gpWKgdaQ/nYcyNqdAVw2cRzB'.
			'hMjGvRWBQq83kazy+jDxO1ao4usJssDCmHSwrct6VKffJdM8Mj'.
			'au2HOaK+V8Y9XsZS+Liu9XvTPpT1cSyd0u0FVm/3eXwqJr5EYn'.
			'+pWIp5Le/hEXk/j2CkoqHaKSd5dVrK2IZYXts0xU1tga35Aywt'.
			'zHRPnX6y+DSGCOOfEYxTCEFUW7fQlv4wdg5Th3kDBDmo0lJQXw'.
			'iJPUeqDyn1807ixbMXsu5sKwUzFVIenyTv3zZUddrUx2lSWtsw'.
			'N+zjyAdzzZHcXOrB1tpqp48jf8+MqN8bCyIaJMNCobxTKfV5kh'.
			'j/AIlW4YwxY7HDRyIMGdtprgJjQKv0lekR1/SR3rI1hfNipfX8'.
			'pmMBeG8VGMfhWJRlVn9PkD8Uj80gCRIkqEAGT5AgYZAECRIkDJ'.
			'KgOshg5u9zKT8jIlKur6R9ppQMZkQ6h+pm608YJEGHoB6LVhwV'.
			'g4AvwxJ7+EJgD8AsWNt6GOQSLGqwR8IgCboaFmOJ3banuFPggV'.
			'h0o+/c5leYj9jDTvkS3eMrOsH5NZM835rBUCy8YDzmkb0Pdt4x'.
			'XatyE2YKnYUFxA3U71M8bQ3ATMAfY1lQwMzyOSyoDiyT+jZYrr'.
			'LVsfihdzHT7Pq6dgvs7Go8ZrbtHtot7ncYqqfamany/hK3PqJ9'.
			'KqT+Gu9C7MxlSaiNvTH3l+fIn6SDJc/bBDMFvxx3UhMzb+3gIe'.
			'yMaF/sNHsOdlB3koh4O+zsYx8sxCHAhdgrDcI4H3P/WEL+7OpS'.
			'lX0gZpuLnVcMxxK5rYXl2LoDy464jHxuroOwkIrvhO4xhOUTAV'.
			'6PvWpipBjqJd0n2Dm+ws7nBmPvGAnc78diGTobMK+QXVX+Wait'.
			'YDwBTiam90giYtUOgiyRW5P3c9oYOxTcADvEXYolb/gMC6GdJc'.
			'J380YFLuQTyGdJH6GVeb6+v4WlEXpH9YMkgYF3wJ2YtwFijNPI'.
			'p7MdjqWIckUpsJcCDRVzTBEz12MHkw3qzzoi+ke1IAzT/13FPJ'.
			'eqznnYQeOVWKbPQ7GXIp0bV59JRKzaQfA2rW3J+zk1idjWwEKi'.
			'F4vIn8cyFR4m61FvlvedCk7I78M8gS8Oyf8NWs1HYu4sDQ4dBd'.
			'feqN0nyG4zk3wIwLsUdmkKdJS/YymkjpL41U1jasayLH6BeU+s'.
			'L5FtRzFYH/V3NY03SJD4inbROmK6VCUMUjsI3HyGYS458/X/GP'.
			'0+EXPxaNFK2uYhaheN5F/PlgtJHQtCxB7lXNmNfD7cnCOxFMv9'.
			'nItoO4f51/Vkef+zgOBP1XgbQvVnSHw7V+LhWH2emzDI1wvLxA'.
			'THY1Gh92JOhCMkAk0QYdZjPmp3aSVuI59B00Ub/ry/aSp7w1S2'.
			'xHrh+vVi8lGYz1qLFPIjpec8LHHzFtF3Dnu9YJDJ/xgtHN8mRl'.
			'BbooPUFsaHFr5HpSesIpHmI5XXSfe4WTvHQKLf295LsnqK6oRP'.
			'14XEtDj1eqsPwctMcyGGuU3j21R97BXSxR4g7xS5nsS0nliK0q'.
			'dksIiVrzdhkNrCZEcnCcycr4qoPsfc3keIae4CfuhZ0XMhy9VE'.
			'MVYL+TdOdXMYJigLE386RF9BWSAWPUz7EN76UN05+nw29oaodf'.
			'X7l1ju5+6ygE3EDh8byYcYXKdrUur3Mu0cY7SADMfCfD+NM6GJ'.
			'iFVbmIadV/SStWYc5uL9oH5fKIX3aiyz+wsiQjc2IyD+N6Tgv4'.
			'W98WqRLEuN5M8msmLM7mKstyXCLZRe8KLKkOUpiHN3RbTAZX2h'.
			'CP8R7JzlTf0FtHqFdpY9MRf70VK+Z2DxIFth0ZMf6r6zMDPzNb'.
			'LuPasxx8oZkJyD1D7qIvSIvljciO+3s8nnV75DxNnsSB1ZjyQS'.
			'xOGkQu3WOeJRVJ+C6Mtw3TVDu4nbTm8xqUvoa2hcgViYDbXfJ9'.
			'ReLCQ7SO2jLaJ8dgzRexXaRz1miyjd2Rj3b4uwXLnlcwpcMz+i'.
			'7/NC7eWc9ueUOnmJDpLAh8UiwMVf94n4/wCTfpWFDR1QzwAAAA'.
			'BJRU5ErkJggg==',
		'wp.png' => 
			'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAFfKj/FAAAAB3RJTUUH1wYQEiwG0'.
			'0adjQAAAAlwSFlzAAALEgAACxIB0t1+/AAAAARnQU1BAACxjwv8YQUAAABOUExURZ'.
			'wMDN7n93ut1kKExjFjnHul1tbn75S93jFrnP///1qUxnOl1sbe71KMxjFrpWOUzjl'.
			'7tYy13q3G5+fv95y93muczu/39zl7vff3//f//9Se9dEAAAABdFJOUwBA5thmAAAA'.
			's0lEQVR42iWPUZLDIAxDRZFNTMCllJD0/hddktWPRp6x5QcQmyIA1qG1GuBUIArwj'.
			'SRITkiylXNxHjtweqfRFHJ86MIBrBuW0nIIo96+H/SSAb5Zm14KnZTm7cQVc1XSMT'.
			'jr7IdAVPm+G5GS6YZHaUv6M132RBF1PopTXiuPYplcmxzWk2C72CfZTNaU09GCM3T'.
			'Ww9porieUwZt9yP6tHm5K5L2Uun6xsuf/WoTXwo7yQPwBXo8H/8TEoKYAAAAASUVO'.
			'RK5CYII=',
	); // $resources = array
				
	if(array_key_exists($_GET['resource'],$resources)) {

		$content = base64_decode($resources[ $_GET['resource'] ]);

		$lastMod = filemtime(__FILE__);
		$client = ( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false );
		// Checking if the client is validating his cache and if it is current.
		if (isset($client) && (strtotime($client) == $lastMod)) {
			// Client's cache IS current, so we just respond '304 Not Modified'.
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT', true, 304);
			exit;
		} else {
			// Image not cached or cache outdated, we respond '200 OK' and output the image.
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT', true, 200);
			header('Content-Length: '.strlen($content));
			header('Content-Type: image/' . substr(strrchr($_GET['resource'], '.'), 1) );
			echo $content;
			exit;
		}	
	}
}


function fb_shirtinator_textdomain() {
	
	if ( function_exists('load_plugin_textdomain') )
		load_plugin_textdomain( 'shirtinator', false, plugin_basename( __FILE__ ) . '/languages');
}


// Display Icons
function fb_shirtinator_get_resource_url($resourceID) {
	return trailingslashit( get_bloginfo('siteurl') ) . '?resource=' . $resourceID;
}


function fb_shirtinator_sub_page() {

	if ($_POST['fb_shirtinator_creator_id']){
		fb_shirtinator_update();
	}
?>
<style type="text/css" media="screen">
	dl dt {
		float:left;
		width:10em;
		text-align:right;
		position:relative /*IEWin hack*/
	}

	dl dd {
		margin-left:10em;
		text-align:left;
		padding-left:.5em
	}
</style>

	<div class="wrap" id="top">
		<form method="post" id="fb_shirtinator_options" action="">
			<h2><?php _e('Shirtinator Creator', 'shirtinator'); ?></h2>
			<br class="clear" />
			
			<div id="poststuff" class="shirtinator">
				<div class="postbox" >
					<h3 class="dbx-handle"><?php _e('Shirtinator Shop-Partner', 'shirtinator') ?></h3>
					<div class="inside">
						<dl>
							<dt><?php _e('Creator ID', 'shirtinator'); ?></dt>
							<dd><input name="fb_shirtinator_creator_id" id="fb_shirtinator_creator_id" value='<?php echo get_option('fb_shirtinator_creator_id'); ?>' /></dd>
							<dd><?php _e('Trage Deine Shirtinator Creator ID ein.', 'shirtinator'); ?><br /><?php _e('Solltest Du keine Shirtinator Creator ID haben, kannst Du dir in nur wenigen Minuten ein kostenloses Benutzerkonto auf <a href="http://shirtinator.de/?cT=signIn">http://www.shirtinator.de</a> anlegen um anschlie&szlig;end Deine Creator ID zu erhalten.', 'shirtinator'); ?></dd>
						</dl>
						<p class="submit"><input class="submit" type="submit" name="Submit" value="<?php _e('Update Options'); ?> &raquo;" /><input type="hidden" name="page_options" value="'dofollow_timeout'" /></p>
					</div>
				</div>
			</div>
					
			<div id="poststuff" class="shirtinator">
				<div class="postbox closed" >
					<h3><?php _e('&Uuml;ber Shirtinator', 'shirtinator') ?></h3>
					<div class="inside">
						<a href="http://www.shirtinator.de"><img style="float:right;" src="<?php echo fb_shirtinator_get_resource_url('shirtinator.png'); ?>" alt="Shirtinator Logo" /></a>
						<h4><?php _e('Shirtinator.de', 'shirtinator'); ?></h4>
						<p><?php _e('<a href="http://shirtinator.de/?cT=signIn">shirtinator.de</a> &mdash; bietet privaten sowie kommerziellen Betreibern von Internetseiten eine Plattform um innerhalb von wenigen Minuten einen T-Shirt Creator individuell anzupassen und diesen in Deine Webseite oder in Deinen Blog einzubinden &ndash; Shirtinator &uuml;bernimmt das ganze Fullfilment d.h. von der Bestellabwicklung &uuml;ber die Produktion, Lagerung, Versand bis hin zum Kundenservice.', 'shirtinator'); ?></p>
						<h4><?php _e('T-Shirt Creator', 'shirtinator'); ?></h4>
						<p><?php _e('Im  shirtinator Creator k&ouml;nnen Deine Besucher T-Shirts und andere Produkte aus unserem Sortiment individuell gestalten und bestellen. F&uuml;r jeden verkauften Artikel der &uuml;ber Deinen Creator abgewickelt wird, erh&auml;ltst Du eine Umsatzprovision von 20% des Nettoverkaufspreises.', 'shirtinator'); ?></p>
						<h4><?php _e('Creator Look &amp; Feel', 'shirtinator'); ?></h4>
						<ul><?php _e('<li>Creator Layout anpassbar</li><li>eigene Motive m&ouml;glich</li>', 'shirtinator'); ?></ul>
						<h4><?php _e('Systemvoraussetzungen', 'shirtinator'); ?></h4>
						<ul><?php _e('<li>PHP5 oder h&ouml;her</li><li>720px Breite</li>', 'shirtinator'); ?></ul>
						<h4><?php _e('Creator ID', 'shirtinator'); ?></h4>
						<p><?php _e('Wird keine Creator ID hinterlegt, so sollte die Standard-Creator-ID (61559) von Shirtinator.de genutzt werden.', 'shirtinator'); ?></p>
						<h4><?php _e('Verwendung', 'shirtinator'); ?></h4>
						<p><?php _e('Um Deinen shirtinator Creator in eine WordPress-Seite zu integrieren, erstelle eine <a href="page-new.php">neue Seite</a> und hinterlege folgenden Code <code>&lt;!--shirtinator--&gt;</code> als Inhalt. Du kannst nat&uuml;rlich zus&auml;tzlichen Inhalt hinterlegen innerhalb der Seite hinterlegen.', 'shirtinator'); ?></p>
					</div>
				</div>
			</div>

		</form>

		<script type="text/javascript">
		<!--
		jQuery('.postbox h3').prepend('<a class="togbox">+</a> ');
		jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
		jQuery('.postbox.close-me').each(function(){
			jQuery(this).addClass("closed");
		});
		//-->
		</script>
	</div>
<?php
}


/**
 * Add action link(s) to plugins page
 * Thanks Dion Hulse -- http://dd32.id.au/wordpress-plugins/?configure-link
 */
function fb_shirtinator_filter_plugin_actions($links, $file){
	static $this_plugin;

	if( !$this_plugin ) $this_plugin = plugin_basename(__FILE__);

	if( $file == $this_plugin ){
		$settings_link = '<a href="options-general.php?page=shirtinator/shirtinator.php">' . __('Settings') . '</a>';
		$links = array_merge( array($settings_link), $links); // before other links
	}
	return $links;
}


/**
 * settings in plugin-admin-page
 */
function fb_shirtinator_add_settings_page() {
	if( current_user_can('manage_options') ) {
		add_options_page( __('Shirtinator configuration', 'shirtinator'), 'Shirtinator', 8, __FILE__, 'fb_shirtinator_sub_page');
		add_filter('plugin_action_links', 'fb_shirtinator_filter_plugin_actions', 10, 2);
	}
}


function fb_shirtinator_start_session() {

	@session_cache_limiter('private');
	@session_cache_expire(0);
	@session_start();
}


function fb_shirtinator_creator() {
	
	if (isset($_GET[ session_name() ])) {
		session_id($_GET[ session_name() ]);
	}
	
	fb_shirtinator_start_session();
	
	$inc_path = WP_PLUGIN_DIR . '/shirtinator/shrRpc/shrRpcClient.php';
	//$inc_path = 'shrRpc/shrRpcClient.php';
	if ( file_exists( $inc_path ) ) {
		@require_once( $inc_path );
	} else {
		wp_die( __('not includable: ' . $inc_path) );
	}
	
	$currentLink = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?";
	$creatorID = get_option('fb_shirtinator_creator_id');
	$rpcClient = new shrRpcClient();
	$rpcClient->setCreatorId( $creatorID );
	$rpcClient->clearRequestStack();
	$getMyCreatorContentParams = array(
	                                   "currentLink" => $currentLink,
	                                   "bIncludeShoppingprocess" => true,
	                                   "bFooterLinks" => true,
	                                   "https" => true,
	                                   "httpsLink"=>"https://www.shirtinator.de/public/myCreator/index.php?",
	);
	
	$rpcClient->addRequest( "getMyCreatorContent", $getMyCreatorContentParams );
	$rpcClient->sendRequest();
	$getMyCreatorContentResponse = $rpcClient->getResponse("getMyCreatorContent");

	echo $getMyCreatorContentResponse['body'];
}

// Filter WordPress Content
function fb_shirtinator_filter($data) {
	$start = strpos($data, SHIRTINATOR_PAGE);

	//ask php-versions
	$phpversion = phpversion();
	
	if ($phpversion >= '5.0.0') {
		if ($start !== false) {
			ob_start();
	
			fb_shirtinator_creator();
	
			$content = ob_get_contents();
			ob_end_clean();
			$data = substr_replace($data, $content, $start, strlen(SHIRTINATOR_PAGE));
		}
	} else {
		echo '<p>';
		_e('PHP Version muss mindestens 5.0.0 sein! Ihr Server besitzt ', 'shirtinator');
		echo $phpversion . '</p>';
	}
	return $data;
}

// update options
function fb_shirtinator_update() {
	if (!empty($_POST)) {
		update_option('fb_shirtinator_creator_id', (int) $_POST['fb_shirtinator_creator_id'] );

		echo '<div class="updated"><p>' . __('Shirtinator options have been saved.', 'shirtinator') . '</p></div>';
	}
}

// install standart options
function fb_shirtinator_install(){
	
	add_option('fb_shirtinator_creator_id', '61559');
}

// uninstall standart options
function fb_shirtinator_uninstall(){
	
	delete_option('fb_shirtinator_creator_id');
}

// WP_Hook add_action
if (function_exists('add_action'))
	add_action('admin_menu', 'fb_shirtinator_add_settings_page');
if ( function_exists('register_activation_hook') )
	register_activation_hook(__FILE__, 'fb_shirtinator_install');
if ( function_exists('register_uninstall_hook') )
	register_uninstall_hook(__FILE__, 'fb_shirtinator_uninstall');

// WP_Hook add_action
if (function_exists('add_filter')) {
	add_filter('the_content', 'fb_shirtinator_filter');
}

?>