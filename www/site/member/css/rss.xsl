<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" 
	xmlns:rss="http://purl.org/rss/1.0/" 
	xmlns:dc="http://purl.org/dc/elements/1.1/" 
	xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#" 
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
>
	<xsl:output method="html" doctype-public="-//W3C//DTD XHTML 1.1//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" indent="yes" encoding="utf-8" media-type="text/html" />

	<xsl:template match="/">
		<xsl:variable name="title" select="rdf:RDF/rss:channel/rss:title" />
		<xsl:variable name="date" select="rdf:RDF/rss:channel/dc:date" />
		<xsl:variable name="link" select="rdf:RDF/rss:channel/rss:link" />
		<xsl:variable name="rdfname">index.rdf</xsl:variable>
		<xsl:apply-templates select="rdf:RDF"/>
	</xsl:template>

	<xsl:template match="rdf:RDF">
	<html xml:lang="ja" lang="ja">
		<head>
			<title><xsl:value-of select="rss:channel/rss:title"/> - RSS1.0 Feed</title>
			
			<meta http-equiv="content-style-type" content="text/css" />
			<meta http-equiv="content-script-type" content="text/javascript" />
			<link rel="stylesheet" href="rss_master.css" type="text/css" />
			<link rel="shortcut icon" href="../img/fav/favicon.ico" />
		</head>
		<body>
			<div id="container">
				<div id="mainCol">
					<div id="rssHeader">
						<h1><a href="{rss:channel/rss:link}"><xsl:value-of select="rss:channel/rss:title"/></a></h1>
						<p id="feedby">RSS 1.0 Feed by <a href="{rss:channel/rss:link}"><xsl:value-of select="rss:channel/rss:link"/></a></p>
						<p id="description"><xsl:value-of select="rss:channel/rss:description"/></p>
					</div>
					<div id="content">
						<ul class="navAux">
							<li><a href="{rss:channel/rss:link}">トップページへ</a></li>
						</ul>
						<h2>最新エントリー15件</h2>
						<div class="item"><xsl:apply-templates select="rss:item"/></div>
					</div>
					<div id="footer">
						<hr />
						<address><a href="{rss:channel/rss:link}">Advanced Creators Members Site</a></address>
					</div>
				</div>
			</div>
		</body>
	</html>
	</xsl:template>

	<xsl:template match="rss:item">
		<li><a href="{rss:link}"><xsl:value-of select="rss:title"/></a> (<xsl:value-of select="dc:date"/>)<br/>
		
			<font color="#555555" size="-1"><xsl:value-of select="rss:description"/></font>
		</li>
	</xsl:template>

</xsl:stylesheet>
