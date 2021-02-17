<div class = "col-lg-3 well" style = "margin-top:110px;background-color:#fefefe;">
				<?php require("cuenta_user.php")?>


				<hr style = "border:1px dotted #d3d3d3;"/>
				<ul id = "menu" class = "nav menu">
					<li><a style = "font-size:14px; border-bottom:1px solid #d3d3d3;" href = "home.php"><i class = "glyphicon glyphicon-home"></i> Inicio</a></li>

			<?php if($_SESSION['rol_id']!=5){ ?>
				<li><a style = "font-size:14px; border-bottom:1px solid #d3d3d3;" href = ""><i class = "glyphicon glyphicon-tasks"></i> Administración</a>

 

						<ul style = "list-style-type:none;">
              <li></li><span style = "font-size:14px; border-bottom:1px solid #d3d3d3;"></i> Organización</span></li>

                                                        <li><a href = "facultad.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Facultades</a></li>
                                                        <li><a href = "carrera.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Carreras</a></li>
                                                        <li><a href = "departamento.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Departamentos</a></li>
                                                        <li><a href = "alumno.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Alumnos</a></li>
														<!-- <li><a href = "evaluador.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Evaluadores</a></li> -->


                                                    <li><span style = "font-size:14px; border-bottom:1px solid #d3d3d3;"> Plan de estudios</span></li>

													<li><a href = "curso.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Cursos</a></li>
                                                    <!--<li><a href = "curso.php" style = "font-size:15px;"><i class = "glyphicon glyphicon-user"></i> Malla</a></li>-->



                                        <li><span style = "font-size:14px; border-bottom:1px solid #d3d3d3;"> Perfil del egresado</span></li>

                                        <li><a href = "tipocompetencia.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Tipo de competencias</a></li>
										<li><a href = "competencia.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Competencias</a></li>
                                        <li><a href = "objgeneral.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Objetivos generales</a></li>
                                        <li><a href = "objespecifico.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Objetivos específicos</a></li>

                                        <!--<li></li><span style = "font-size:14px; border-bottom:1px solid #d3d3d3;"></i> Fase3</span></li>

                                                        <li><a href = "tipoevaluacion.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Tipos de evaluación</a></li>
                                                        <!--<li><a href = "evaluador.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Evaluadores</a></li>-->


						</ul>

                                       </li>


				<li><a style = "font-size:14px; border-bottom:1px solid #d3d3d3;" href = ""><i class = "glyphicon glyphicon-th"></i> Diseño Curricular</a>

						<ul style = "list-style-type:none;">
                            <li><a href = "malla.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Mallas curriculares</a></li>
							<li><a href = "carreracompetencia.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Competencias por carrera</a></li>
							<li><a href = "carreraog.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Objetivos generales por carrera</a></li>
                            <li><a href = "ogoe.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Objetivos de aprendizaje</a></li>
														<li><a href = "tipoAporte.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Nivel de aporte</a></li>


						</ul>

                </li>
					<?php } ?>


				<li><a style = "font-size:14px; border-bottom:1px solid #d3d3d3;" href = ""><i class = "glyphicon glyphicon-tasks"></i> AoL</a>

						<ul style = "list-style-type:none;">
							<?php if($_SESSION['rol_id']!=5){ ?>
						 <li></li><span style = "font-size:14px; border-bottom:1px solid #d3d3d3;"></i> Rúbricas</span></li>
							<li><a href = "nivel.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Niveles de desempeño</a></li>
							<!-- <li><a href = "criterio2.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Criterios</a></li> -->
							<li><a href = "criterio2.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Criterio de evaluación y sus niveles de desempeño</a></li>
							<!-- <li><a href = "subcriterio.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Descripción por niveles de desempeño</a></li> -->
							<!-- <li><a href = "rubrica2.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Criterios por niveles de desempeño</a></li> -->
							<li><a href = "rubricas.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Curso y sus criterios de evaluación</a></li>

						<li></li><span style = "font-size:14px; border-bottom:1px solid #d3d3d3;"></i> Evaluaciones</span></li>
											<li><a href = "evaluador.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Evaluadores</a></li>
                            <li><a href = "grupoAlumno.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Grupo de Alumnos</a></li>
							<li><a href = "tipoevaluacion.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Tipos de evaluación</a></li>
						<?php } ?>
                           	<li><a href = "gEvaluacion.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Evaluación</a></li>

						</ul>

                </li>



						<li><a style = "font-size:14px; border-bottom:1px solid #d3d3d3;" href = ""><i class="glyphicon glyphicon-file"></i> Reportes</a>

							<ul style = "list-style-type:none;">
								<li></li><span style = "font-size:14px; border-bottom:1px solid #d3d3d3;"></i> Por carrera</span></li>
								<li><a href = "reportesMallaPerfil.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Malla curricular</a></li>
								<li><a href = "reportesPerfilMalla.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Perfil de egreso</a></li>
								<li><a href = "reportesVinculado.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Vínculo entre el Perfil de egreso y la Malla curricular</a></li>
								<li><a href = "reportesMenuCurso.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Cursos según aporte a las competencias</a></li>
								<li><a href = "reportesCursoNivel.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Cursos según nivel de aporte a los objetivos de aprendizaje</a></li>
								<li><a href = "reportesLogroCarrera.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Logro de competencias del alumno por carrera</a></li>
								<li><a href = "reportesRubriCarrera.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Rubricas por carrera</a></li>

							</ul>
						</li>


				<!--	<li><a style = "font-size:18px; border-bottom:1px solid #d3d3d3;" href = ""><i class = "glyphicon glyphicon-th"></i> Proceso AOL</a>
						<ul style = "list-style-type:none;">
							<li><a href = "borrowing.php" style = "font-size:15px;"><i class = "glyphicon glyphicon-random"></i> Plan academico</a></li>
							<li><a href = "returning.php" style = "font-size:15px;"><i class = "glyphicon glyphicon-random"></i> Evaluaciones</a></li>
						</ul>
					</li>-->


                                <?php if($_SESSION['rol_id']==1){ ?>
					<li><a  style = "font-size:14px; border-bottom:1px solid #d3d3d3;" href = ""><i class = "glyphicon glyphicon-cog"></i> Seguridad</a>
						<ul style = "list-style-type:none;">
                                                        <li><a href = "usuario.php" style = "font-size:14px;"><i class = "glyphicon glyphicon-minus"></i> Usuarios</a></li>
						</ul>
					</li> <?php }?>

                                        <li><a style = "font-size:14px; border-bottom:1px solid #d3d3d3;" href = "logout.php"><i class = "glyphicon glyphicon-log-out"></i> Cerrar Sesión</a></li>




				</ul>
			</div>
