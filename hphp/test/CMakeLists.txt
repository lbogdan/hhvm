set(CXX_SOURCES)
add_definitions("-DHHVM_PATH=\"${CMAKE_CURRENT_SOURCE_DIR}/../hhvm/hhvm\"")

set(RECURSIVE_SOURCE_SUBDIRS ext)
foreach (dir ${RECURSIVE_SOURCE_SUBDIRS})
  auto_sources(files "*.cpp" "RECURSE" "${CMAKE_CURRENT_SOURCE_DIR}/${dir}")
  list(APPEND CXX_SOURCES ${files})
endforeach(dir ${RECURSIVE_SOURCE_SUBDIRS})

list(APPEND CXX_SOURCES ${files})
list(APPEND CXX_SOURCES "${CMAKE_CURRENT_SOURCE_DIR}/../hhvm/process-init.cpp")
list(APPEND CXX_SOURCES
     "${CMAKE_CURRENT_SOURCE_DIR}/../hhvm/global-variables.cpp")

if(NOT HAVE_CUSTOM_LIBEVENT)
  list(REMOVE_ITEM CXX_SOURCES
       "${CMAKE_CURRENT_SOURCE_DIR}/ext/test_ext_curl.cpp")
endif()

if (NOT ENABLE_FASTCGI)
  list(REMOVE_ITEM CXX_SOURCES
       "${CMAKE_CURRENT_SOURCE_DIR}/ext/test_fastcgi.cpp")
  list(REMOVE_ITEM CXX_SOURCES
       "${CMAKE_CURRENT_SOURCE_DIR}/ext/test_fastcgi_protocol.cpp")
endif()

add_executable(test ${CXX_SOURCES})
target_link_libraries(test ${HHVM_LINK_LIBRARIES})
embed_all_systemlibs(test "${CMAKE_CURRENT_BINARY_DIR}/.." "${CMAKE_CURRENT_BINARY_DIR}/test")
add_dependencies(test systemlib)
if (ENABLE_COTIRE)
  cotire(test)
endif()
