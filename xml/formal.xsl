<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="UTF-8" indent="yes" />
    <xsl:param name="estilo" />
    <xsl:param name="categoria" />
    <xsl:param name="id_usuario" />
    <xsl:param name="id_cv" />

    <xsl:template match="/">
            <xsl:apply-templates select="generadorcv/usuariado/cuenta"/>
            <xsl:apply-templates select="generadorcv/curriculums/CV"/>
    </xsl:template>

    <xsl:template match="cuenta">
        <xsl:if test="@id = $id_usuario">
            <table style="width: 80%; margin: auto; padding-top: 60px; border-spacing: 10px;">
                <tr>
                    <th style="font-size: 40px; border-bottom: solid 1px black; text-align: left;">
                        <xsl:apply-templates select="nombre"/>
                        <br/>
                        <xsl:apply-templates select="apellidos"/>
                    </th>
                </tr>
            </table>
            <table style="border-spacing: 13px; position: absolute; left: 10%; top: 14.6%;">
                <tr>
                    <th style="font-size: 25px; text-align: left">Datos<br></br>personales</th>
                </tr>
                <tr>
                    <th style=" text-align: left">Nombre</th>
                </tr>
                <tr>
                    <td>
                        <xsl:apply-templates select="nombre"/>
                    </td>
                </tr>
                <tr>
                    <th style=" text-align: left">Apellidos</th>
                </tr>
                <tr>
                    <td>
                        <xsl:apply-templates select="apellidos"/>
                    </td>
                </tr>
                <tr>
                    <th style=" text-align: left">Correo electrónico</th>
                </tr>
                <tr>
                    <td>
                        <xsl:apply-templates select="mail"/>
                    </td>
                </tr>
            </table>
        </xsl:if>
    </xsl:template>

    <xsl:template match="CV">
        <xsl:if test="@cuenta = $id_usuario and @id = $id_cv">
            <table style="width: 55%; border-spacing: 13px; border-left: solid 1px black; position: absolute; right: 10%; top: 14.6%;">
                <tr>
                    <th style="font-size: 25px; text-align: left">Formación</th>
                </tr>
                <xsl:for-each select="formacion/titulacion">
                    <tr>
                        <th style=" text-align: left">
                            <b><xsl:apply-templates select="nombre"/></b> (<xsl:apply-templates select="centro"/>)
                        </th>
                        <td>
                            <xsl:apply-templates select="fecha"/>
                        </td>
                    </tr>
                </xsl:for-each>
                    <tr></tr>
                    <tr>
                        <th style="font-size: 25px; text-align: left">Experiencia</th>
                    </tr>
                <xsl:choose>
                    <xsl:when test="$categoria = 'nada'">
                        <xsl:for-each select="experiencia/item">
                            <tr>
                                <th style=" text-align: left" colspan="2">
                                    <xsl:apply-templates select="titulo"/>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <xsl:apply-templates select="fecha_inicio"/> - 
                                    <xsl:apply-templates select="fecha_fin"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <xsl:apply-templates select="descripcion"/>
                                </td>
                            </tr>
                        </xsl:for-each>
                    </xsl:when>
                    <xsl:when test="$categoria != 'nada'">
                        <xsl:for-each select="experiencia/item">
                            <xsl:if test="categoria = $categoria">
                                <tr>
                                    <th style=" text-align: left" colspan="2">
                                        <xsl:apply-templates select="titulo"/>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <xsl:apply-templates select="fecha_inicio"/> - 
                                        <xsl:apply-templates select="fecha_fin"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <xsl:apply-templates select="descripcion"/>
                                    </td>
                                </tr>
                            </xsl:if>
                        </xsl:for-each>
                    </xsl:when>
                </xsl:choose>
                <tr></tr>
                <tr>
                    <th style="font-size: 25px; text-align: left">Idioma</th>
                </tr>
                <xsl:for-each select="formacion/idioma">
                    <tr>
                        <th style=" text-align: left">
                            <xsl:apply-templates select="nombre"/> (<xsl:apply-templates select="certificado"/>)
                        </th>
                        <td>
                            <xsl:apply-templates select="nivel"/>
                        </td>
                    </tr>
                </xsl:for-each>
            </table>
        </xsl:if>
    </xsl:template>

    <xsl:template match="fecha">
        <xsl:variable name="dia" select="substring(., 9, 2)" />
        <xsl:variable name="mes" select="substring(., 6, 2)" />
        <xsl:variable name="anio" select="substring(., 1, 4)" />
        <xsl:value-of select="concat($dia, '/', $mes, '/', $anio)" />
    </xsl:template>

    <xsl:template match="fecha_inicio">
        <xsl:variable name="dia" select="substring(., 9, 2)" />
        <xsl:variable name="mes" select="substring(., 6, 2)" />
        <xsl:variable name="anio" select="substring(., 1, 4)" />
        <xsl:value-of select="concat($dia, '/', $mes, '/', $anio)" />
    </xsl:template>

    <xsl:template match="fecha_fin">
        <xsl:variable name="dia" select="substring(., 9, 2)" />
        <xsl:variable name="mes" select="substring(., 6, 2)" />
        <xsl:variable name="anio" select="substring(., 1, 4)" />
        <xsl:value-of select="concat($dia, '/', $mes, '/', $anio)" />
    </xsl:template>
</xsl:stylesheet>