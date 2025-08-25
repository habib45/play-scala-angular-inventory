name := "inventory-management-system"

version := "1.0-SNAPSHOT"

lazy val root = (project in file(".")).enablePlugins(PlayScala)

scalaVersion := "2.13.12"

libraryDependencies ++= Seq(
  guice,
  "org.scalatestplus.play" %% "scalatestplus-play" % "7.0.0" % Test,
  "mysql" % "mysql-connector-java" % "8.0.33",
  "org.playframework" %% "play-slick" % "6.0.0",
  "org.playframework" %% "play-slick-evolutions" % "6.0.0",
  "com.typesafe.slick" %% "slick" % "3.4.1",
  "com.typesafe.slick" %% "slick-hikaricp" % "3.4.1",
  "com.auth0" % "java-jwt" % "4.4.0",
  "org.mindrot" % "jbcrypt" % "0.4",
  "org.scalatestplus" %% "mockito-4-11" % "3.2.17.0" % Test,
  "com.h2database" % "h2" % "2.2.224" % Test
)

// Adds additional packages into Twirl
//TwirlKeys.templateImports += "com.example.controllers._"

// Adds additional packages into conf/routes
play.sbt.routes.RoutesKeys.routesImport += "binders._"