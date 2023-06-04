<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="UTF-8" indent="yes" />
    <xsl:param name="estilo" />
    <xsl:param name="categoria" />
    <xsl:param name="id_usuario" />
    <xsl:param name="id_cv" />

    <xsl:template match="cuenta">
        <xsl:if test="@id = $id_usuario">
            <tr>
                <th style="text-align: center; font-size: 40px; color: rgb(16, 84, 173);" colspan="2">
                    <xsl:apply-templates select="nombre"/>&#160;<xsl:apply-templates select="apellidos"/>
                </th>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <th style="font-size: 25px; border-bottom: solid 1px rgb(21, 108, 223); text-align: left; color: rgb(21, 108, 223);" colspan="2" class="seccion">Datos personales</th>
            </tr>
            <tr>
                <th style="width: 40%; text-align: right">Nombre</th>
                <td style="width: 60%; text-align: left;">
                    <xsl:apply-templates select="nombre"/>
                </td>
            </tr>
            <tr>
                <th style="width: 40%; text-align: right">Apellidos</th>
                <td style="width: 60%; text-align: left;">
                    <xsl:apply-templates select="apellidos"/>
                </td>
            </tr>
            <tr>
                <th style="width: 40%; text-align: right">Correo electrónico</th>
                <td style="width: 60%; text-align: left;">
                    <xsl:apply-templates select="mail"/>
                </td>
            </tr>
            <tr></tr>
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


    <xsl:template match="CV">
        <xsl:if test="@cuenta = $id_usuario and @id = $id_cv">
            <tr>
                <th style="font-size: 25px; border-bottom: solid 1px rgb(21, 108, 223); text-align: left; color: rgb(21, 108, 223);" colspan="2" class="seccion">Formación</th>
            </tr>
            <xsl:for-each select="formacion/titulacion">
                <tr>
                    <th style="width: 30%;">
                        <xsl:apply-templates select="fecha"/>
                    </th>
                    <td style="width: 35%; text-align: left;">
                        <b><xsl:apply-templates select="nombre"/></b> (<xsl:apply-templates select="centro"/>)
                    </td>
                </tr>
            </xsl:for-each>
                <tr></tr>
                <tr>
                    <th style="font-size: 25px; border-bottom: solid 1px rgb(21, 108, 223); text-align: left; color: rgb(21, 108, 223);" colspan="2" class="seccion">Experiencia</th>
                </tr>
            <xsl:choose>
                <xsl:when test="$categoria = 'nada'">
                    <xsl:for-each select="experiencia/item">
                        <tr>
                            <th style="width: 30%;">
                                <xsl:apply-templates select="fecha_inicio"/> - 
                                <xsl:apply-templates select="fecha_fin"/>
                            </th>
                            <th style="width: 70%; text-align: left;">
                                <xsl:apply-templates select="titulo"/>
                            </th>
                        </tr>
                        <tr>
                            <td style="width: 30%;"></td>
                            <td style="width: 70%;">
                                <xsl:apply-templates select="descripcion"/>
                            </td>
                        </tr>
                    </xsl:for-each>
                </xsl:when>
                <xsl:when test="$categoria != 'nada'">
                    <xsl:for-each select="experiencia/item">
                        <xsl:if test="categoria = $categoria">
                            <tr>
                                <th style="width: 30%;">
                                    <xsl:apply-templates select="fecha_inicio"/> - 
                                    <xsl:apply-templates select="fecha_fin"/>
                                </th>
                                <th style="width: 70%; text-align: left;">
                                    <xsl:apply-templates select="titulo"/>
                                </th>
                            </tr>
                            <tr>
                                <td style="width: 30%;"></td>
                                <td style="width: 70%;">
                                    <xsl:apply-templates select="descripcion"/>
                                </td>
                            </tr>
                        </xsl:if>
                    </xsl:for-each>
                </xsl:when>
            </xsl:choose>
            <tr></tr>
            <tr>
                <th style="font-size: 25px; border-bottom: solid 1px rgb(21, 108, 223); text-align: left; color: rgb(21, 108, 223);" colspan="2">Idioma</th>
            </tr>
            <xsl:for-each select="formacion/idioma">
                <tr>
                    <th style="width: 33%; text-align: right;">
                        <xsl:apply-templates select="nombre"/>
                    </th>
                    <td style="width: 33%; text-align: left;">
                        <xsl:apply-templates select="nivel"/> (<xsl:apply-templates select="certificado"/>)
                    </td>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>

    <xsl:template match="/">
        <table style="width: 80%; margin: auto; padding-top: 60px; border-spacing: 10px;">
            <xsl:apply-templates select="generadorcv/usuariado/cuenta"/>
            <xsl:apply-templates select="generadorcv/curriculums/CV"/>
        </table>
    </xsl:template>
</xsl:stylesheet>